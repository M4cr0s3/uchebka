<?php

namespace Modules\Ticket\Enum;

enum TicketStatusEnum: string
{
    case DECORATED = 'Оформлен';
    case COMPLETED = 'Завершен';

}
