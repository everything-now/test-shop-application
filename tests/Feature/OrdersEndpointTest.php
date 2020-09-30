<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Order;
use App\Events\Ordered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use App\Listeners\SendEmailOrderedNotifications;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderedAdminNotification;
use App\Mail\OrderedPurchaserNotification;

class OrdersEndpointTest extends TestCase
{
    use RefreshDatabase;

    protected $endpoint = '/api/orders';

    protected $data = [
        'email' => 'email@test.com',
        'phone' => '77777777777',
        'zip_postal_code' => '77777',
        'country_code' => 'EN',
        'city' => 'London',
        'shipping_adress_1' => 'Main Street 57/2',
        'quantity' => 10,
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Test Post Order Success
     *
     * @return void
     */
    public function testPostOrderSuccess()
    {
        $this->expectsEvents(Ordered::class);

        // Set product id
        $this->data['product_id'] = Product::first()->id;

        // Send order
        $response = $this->json('post', $this->endpoint, $this->data);

        // Success response
        $response->assertStatus(200);

        // Order was created
        $this->assertEquals(1, Order::count());

        // Event was dispatched
        Event::assertDispatched(function (Ordered $event) {
            return $event->order->id == Order::first()->id;
        });
    }

    /**
     * Test Post Order Queue Success
     *
     * @return void
     */
    public function testPostOrderQueueSuccess()
    {
        Queue::fake();

        // Assert that no jobs were pushed
        Queue::assertNothingPushed();

        // Set product id
        $this->data['product_id'] = Product::first()->id;

        // Send order
        $response = $this->json('post', $this->endpoint, $this->data);

        // Success response
        $response->assertStatus(200);

        // Assert a specific type of job was pushed meeting the given truth test
        Queue::assertPushed(CallQueuedListener::class, function ($job) {
            return $job->class == SendEmailOrderedNotifications::class;
        });
    }

    /**
     * Test Post Order Mail Success
     *
     * @return void
     */
    public function testPostOrderMailSuccess()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        // Set product id and email
        $email = 'purchaser@email.com';
        $this->data['email'] = $email;
        $this->data['product_id'] = Product::first()->id;

        // Send order
        $response = $this->json('post', $this->endpoint, $this->data);

        // Success response
        $response->assertStatus(200);

        // Mail has been sent to admin
        Mail::assertSent(function (OrderedAdminNotification $mail) {
            return $mail->order->id === Order::first()->id;
        });

        // Mail has been sent to purchaser
        Mail::assertSent(function (OrderedPurchaserNotification $mail) use ($email) {
            return $mail->hasTo($email);
        });
    }

    /**
     * Test Post Order Failure
     *
     * @return void
     */
    public function testPostOrderFailureWrongProductId()
    {
        $this->withoutEvents();

        $this->data['product_id'] = 'wrong';

        $response = $this->json('post', $this->endpoint, $this->data);

        $response->assertStatus(422);
        $this->assertEquals(0, Order::count());
    }

    /**
     * Test Post Order Failure
     *
     * @return void
     */
    public function testPostOrderFailureWrongEmail()
    {
        $this->data['product_id'] = Product::first()->id;
        $this->data['email'] = 'wrong';

        $response = $this->json('post', $this->endpoint, $this->data);

        $response->assertStatus(422);
        $this->assertEquals(0, Order::count());
    }

    /**
     * Test Post Order Forbidden
     *
     * @return void
     */
    public function testPostOrderForbidden()
    {
        $response = $this->json('post', $this->endpoint, $this->data, [
            'REMOTE_ADDR' => '1.0.4.0' // Australia
        ]);

        $response->assertStatus(403);

        $response = $this->json('post', $this->endpoint, $this->data, [
            'REMOTE_ADDR' => '152.200.0.0' // Colombia
        ]);

        $response->assertStatus(403);
    }
}
