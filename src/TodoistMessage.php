<?php

namespace NotificationChannels\Todoist;

use DateTime;
use DateTimeZone;
use NotificationChannels\Todoist\Exceptions\CouldNotCreateMessage;

class TodoistMessage
{
    /** @var string */
    protected $content;

    /** @var int|string */
    protected $projectId;

    /** @var int */
    protected $priority;

    /** @var int */
    protected $indent;

    /** @var int */
    protected $itemOrder;

    /** @var bool */
    protected $collapsed;

    /** @var string|null */
    protected $due;

    /**
     * @param string $content
     *
     * @return static
     */
    public static function create($content)
    {
        return new static($content);
    }

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Set the ticket content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the ticket project_id.
     *
     * @param int $projectId
     *
     * @return $this
     */
    public function projectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Set the ticket priority.
     *
     * @param int $priority
     *
     * @throws CouldNotCreateMessage
     *
     * @return $this
     */
    public function priority($priority)
    {
        if ($priority < 1 || $priority > 4) {
            throw CouldNotCreateMessage::invalidPriority($priority);
        }
        $this->priority = $priority;

        return $this;
    }

    /**
     * Set the ticket indent.
     *
     * @param int $indent
     *
     * @throws CouldNotCreateMessage
     *
     * @return $this
     */
    public function indent($indent)
    {
        if ($indent < 1 || $indent > 4) {
            throw CouldNotCreateMessage::invalidIndent($indent);
        }
        $this->indent = $indent;

        return $this;
    }

    /**
     * Set the ticket item order.
     *
     * @param int $itemOrder
     *
     * @return $this
     */
    public function itemOrder($itemOrder)
    {
        $this->itemOrder = $itemOrder;

        return $this;
    }

    /**
     * Set the ticket as collapsed.
     *
     * @return $this
     */
    public function collapsed()
    {
        $this->collapsed = true;

        return $this;
    }

    /**
     * Set the card position due date.
     *
     * @param string|DateTime $due
     *
     * @return $this
     */
    public function due($due)
    {
        if (! $due instanceof DateTime) {
            $due = new DateTime($due);
        }

        $due->setTimezone(new DateTimeZone('UTC'));

        $this->due = $due->format(DateTime::ATOM);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type' => 'item_add',
            'temp_id' => uniqid(),
            'uuid' => uniqid(),
            'args' => [
                'content' => $this->content,
                'project_id' => $this->projectId,
                'date_string' => $this->due,
                'item_order' => $this->itemOrder,
                'priority' => $this->priority,
                'indent' => $this->indent,
                'collapsed' => $this->collapsed,
            ],
        ];
    }
}
