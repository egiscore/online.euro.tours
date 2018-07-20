<?php
$_messages = array(
    'PAGE_TITLE' => 'Messages',
    'MSG_TOTAL_COUNT' => 'Total',
    'MSG_UNREAD_COUNT' => 'Unread',
    'MSG_UNREAD_COUNT_TO' => 'Unread by operator',
    'MSG_LAST_MESSAGE' => 'Last message',
    'MSG_TOPICS' => 'Message',
    'MSG_ANSWERS' => 'Answers',
    'MESSAGES' => 'Messages',
    'MESSAGES_CLAIM' => 'Messages for reservation',
    'MESSAGES_UNREAD' => 'Unread',
    'MESSAGES_UNREAD_EMPTY' => 'No unread messages',
    'MESSAGES_RECENT' => 'All messages',
    'MSG_REPLY' => 'Reply',
    'MSG_SEND_BUTTON' => 'Send',
    'RELOAD_PAGE' => 'For correct operation, you need to refresh the page.',
    'MSG_CLAIM' => 'Reservation',
    'MSG_CREATE' => 'New message',
    'MSG_TEXT' => 'Message body',
    'MSG_SUBJECT' => 'Subject',
    'MSG_READ_MORE' => 'read more',
    'MSG_ERROR_CLAIM_EMPTY' => 'Not filled in the field "Reservation".',
    'MSG_ERROR_SUBJECT_EMPTY' => 'Not filled in the field "Subject".',
    'MSG_ERROR_TEXT_EMPTY' => 'Blank message could not be sent.',
    'MSG_ERROR_SUBJECT_TOO_LONG' => 'The maximum length of the subject is %d characters.',
    'MSG_ERROR_CLAIM' => "You can't leave a message to the reservation '%s', check room.",
    'MSG_REPLY_DENY' => 'Function disabled.',
    'MSG_CREATE_DENY' => 'Function disabled.',
    'MSG_ERROR_MESSAGETYPE_EMPTY' => 'Select the destination of the message',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
