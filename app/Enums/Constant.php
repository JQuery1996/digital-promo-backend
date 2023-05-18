<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Constant extends Enum
{
    const  VALIDATE_FOR =   60*3;
    const  DATE_TIME_FORMATE = "Y-m-d H:i:s";
    const  SERVICE_ID = 7;
    const  OPERATOR_ID = 10;
    const  CHANNEL_ID = 2;
    const  PLAN_ID_MTN = 18;
    const  PLAN_ID_SYRIATEL = 17;
    const  PREFERRED = 1;
    const  SIGNIFICANT_INTERNATIONAL = 2;
    const  ACOUNT_NAME_SYRIATEL = "SYRIATEL";
    const  ACOUNT_NAME_MTN = "MTN-SY";
    const  GAME_VALIDITY_TIME = 24;
    const  MEMORY_GAME_ID = 1;
    const  QUESTION_GAME_ID = 2;





}
