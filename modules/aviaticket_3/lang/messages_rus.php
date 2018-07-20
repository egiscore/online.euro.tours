<?php
$_messages = array(
    'PAGE_TITLE' => 'Печать авиабилетов',
    'POPUP_TITLE' => 'Печать авиабилетов для заявки',
    'CAN_NOT_LOAD_CLAIM_INFO' => 'Ошибка при загрузке информации по заявке. Обратитесь к туроператору.',
    'TOUR_ALREADY_BEGIN' => 'Печать запрещена, так как тур уже начался',
    'CANNOT_PRINT_DAYS' => 'Печать запрещена, так как до начала тура больше %d дней.',
    'MORE_COMMON' => 'К размещению прикреплено несколько туристов. Обратитесь к туроператору.',
    'TICKET_DITRIBUTED' => 'Билеты уже выданы. Обратитесь к туроператору.',
    'NO_TICKET_NUMBER' => 'Не указан номер билета. Обратитесь к туроператору.',
    'CAN_NOT_LOAD_RESULT_PEOPLEINFO' => 'Нет возможности загрузить информацию по туристу',
    'TRANSPORT' => 'Транспорт',
);
if (isset($messages) && is_array($messages)) {
    $messages = array_merge($messages, $_messages);
} else {
    $messages = $_messages;
}
