<?php

namespace NotificationChannels\Todoist\Test;

use DateTime;
use Illuminate\Support\Arr;
use NotificationChannels\Todoist\Exceptions\CouldNotCreateMessage;
use NotificationChannels\Todoist\TodoistMessage;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \NotificationChannels\Todoist\TodoistMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();

        $this->message = new TodoistMessage('');
    }

    /** @test */
    public function it_accepts_a_content_when_constructing_a_message()
    {
        $message = new TodoistMessage('Content');

        $this->assertEquals('Content', Arr::get($message->toArray(), 'args.content'));
    }

    /** @test */
    public function it_provides_a_create_method()
    {
        $message = TodoistMessage::create('Content');

        $this->assertEquals('Content', Arr::get($message->toArray(), 'args.content'));
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $this->message->content('TicketContent');

        $this->assertEquals('TicketContent', Arr::get($this->message->toArray(), 'args.content'));
    }

    /** @test */
    public function it_can_set_the_project_id()
    {
        $this->message->projectId(10);

        $this->assertEquals(10, Arr::get($this->message->toArray(), 'args.project_id'));
    }

    /** @test */
    public function it_can_set_the_item_order()
    {
        $this->message->itemOrder(10);

        $this->assertEquals(10, Arr::get($this->message->toArray(), 'args.item_order'));
    }

    /** @test */
    public function it_can_set_a_due_date_from_string()
    {
        $date = new DateTime('tomorrow');
        $this->message->due('tomorrow');

        $this->assertEquals($date->format(DateTime::ATOM), Arr::get($this->message->toArray(), 'args.date_string'));
    }

    /** @test */
    public function it_can_set_a_due_date_from_datetime()
    {
        $date = new DateTime('tomorrow');
        $this->message->due($date);

        $this->assertEquals($date->format(DateTime::ATOM), Arr::get($this->message->toArray(), 'args.date_string'));
    }

    /** @test */
    public function it_can_set_the_ticket_as_collapsed()
    {
        $this->message->collapsed();

        $this->assertEquals(true, Arr::get($this->message->toArray(), 'args.collapsed'));
    }

    /** @test */
    public function it_has_default_messages_not_collapsed()
    {
        $this->assertEquals(false, Arr::get($this->message->toArray(), 'args.collapsed'));
    }

    /**
     * @test
     *
     * @dataProvider priorityProvider
     *
     * @param int $priority
     */
    public function it_can_set_a_priority($priority)
    {
        $this->message->priority($priority);

        $this->assertEquals($priority, Arr::get($this->message->toArray(), 'args.priority'));
    }

    public function priorityProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }

    /** @test */
    public function it_throws_an_exception_when_the_priority_is_invalid()
    {
        $this->setExpectedException(CouldNotCreateMessage::class);

        $this->message->priority(5);
    }

    /**
     * @test
     *
     * @dataProvider indentProvider
     *
     * @param int $indent
     */
    public function it_can_set_a_indent($indent)
    {
        $this->message->indent($indent);

        $this->assertEquals($indent, Arr::get($this->message->toArray(), 'args.indent'));
    }

    public function indentProvider()
    {
        return [
            [1],
            [2],
            [3],
            [4],
        ];
    }

    /** @test */
    public function it_throws_an_exception_when_the_indent_is_invalid()
    {
        $this->setExpectedException(CouldNotCreateMessage::class);

        $this->message->indent(5);
    }
}
