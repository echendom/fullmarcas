<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransBank extends Model
{
    use HasFactory;

     /**
     * Constant for PayPal payment method.
     *
     * @var string
     */
    const PAYMENT_METHOD_PAYPAL = 'paypal';

    /**
     * Constant for Transbank payment method.
     *
     * @var string
     */
    const PAYMENT_METHOD_TRANSBANK = 'transbank';

    /**
     * Constant for Transfer payment method.
     *
     * @var string
     */
    const PAYMENT_METHOD_TRANSFER = 'transfer';

    /**
     * Constant for Company Contribution payment method.
     *
     * @var string
     */
    const PAYMENT_METHOD_COMPANY_CONTRIBUTION = 'company_contribution';

    /**
     * Constant for one-time donation type.
     *
     * @var string
     */
    const DONATION_TYPE_ONE_TIME = 'one_time';

    /**
     * Constant for monthly donation type.
     *
     * @var string
     */
    const DONATION_TYPE_MONTHLY = 'monthly';

    /**
     * Pending donation status.
     *
     * @var string
     */
    const STATUS_PENDING = 'pending';

    /**
     * Failed donation status.
     *
     * @var string
     */
    const STATUS_FAILED = 'failed';

    /**
     * Successful donation status.
     *
     * @var string
     */
    const STATUS_SUCCESSFUL = 'successful';

    /**
     * Refunded donation status.
     *
     * @var string
     */
    const STATUS_REFUNDED = 'refunded';

    /**
     * Status of cancelled donation.
     *
     * @var string
     */
    const STATUS_CANCELLED = 'cancelled';

    const STATUS_AUTHORIZED = 'AUTHORIZED';


    // public static function get
}
