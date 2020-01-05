<?php

namespace App\Modules\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use \Exception;

/**
 * Class User
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * It have existing DB table name and it connect to this model with existing DB table
     */
    protected $table = 'users';

    /**
     * It have existing table's primary Key column name and it connect to this model with existing table's primary Key
     * Primary key should have always auto increment property.
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'email', 'password', 'profilepic', 'role', 'status', 'schools_id'];

    /**
     * The attributes that are hidden for security.
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * It is a private static variable which will keep object of this model class
     */
    private static $_instance = null;

    /**
     * It create the instance of this model class
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))
            self::$_instance = new User();
        return self::$_instance;
    }

    /**
     * It updates the admin passwords
     */
    public function updateAdminPassword($password)
    {
        try {
            $result = Admin::where('id', '=', Auth::user()->id)
                ->update(['password' => Hash::make($password)]);

            if ($result)
                return 'success';
            else
                return 'fail';

        } catch (\Exception $e) {
            return 'exception';
        }
    }

    /**
     * It returns admin details
     */
    public function getAdminDetail()
    {
        try {
            return DB::table('admin')
                ->where('id', '=', Auth::user()->id)
                ->select('name', 'last_name', 'email', 'username', 'profilepic')
                ->first();
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * It updates the admin details.
     */
    public function updateAdminDetail($adminData)
    {
        try {
            return DB::table('admin')
                ->where('id', '=', Auth::user()->id)
                ->update($adminData);
        } catch (\Exception $e) {
            return 'exception';
        }
    }

    /**
     * It returns all calculated data to dashboard
     */
    public function getRecordsForDashboard()
    {
        try {
            $userDetails = (array) DB::table('users')
                ->select(DB::raw("COUNT(1) as allUser,
                COUNT(if(status = 0,1,NULL) || if(status = 2,1,NULL)) as inactiveUser,
                (COUNT(if(status = 0,1,NULL) || if(status = 2,1,NULL))*100)/COUNT(1) as percentageInactiveUser,
                COUNT(if(status = 1,1,NULL)) as activeUser,
                (COUNT(if(status = 1,1,NULL))*100)/COUNT(1) as percentageActiveUser,
                COUNT(if(status = 4,1,NULL)) as deletedUser,
                (COUNT(if(status = 4,1,NULL))*100)/COUNT(1) as percentageDeletedUser"))
                ->first();

            $productDetails = (array) DB::table('products')
                ->select(DB::raw(" COUNT(1) as allProduct,
                COUNT(if(product_status = 0,1,NULL)) as inactiveProduct,
                (COUNT(if(product_status = 0,1,NULL))*100)/COUNT(1) as percentageInactiveProduct,
                COUNT(if(product_status = 1,1,NULL)) as activeProduct,
                (COUNT(if(product_status = 1,1,NULL))*100)/COUNT(1) as percentageActiveProduct,
                COUNT(if(product_status = 4,1,NULL)) as deletedProduct,
                (COUNT(if(product_status = 4,1,NULL))*100)/COUNT(1) as percentageDeletedProduct,
                COUNT(if(product_status = 5,1,NULL)) as upcomingProduct,
                (COUNT(if(product_status = 5,1,NULL))*100)/COUNT(1) as percentageUpcomingProduct"))
                ->first();

            $orderDetails = (array) DB::table('order_detail')
                ->select(DB::raw("COUNT(1) as allOrders,
                COUNT(if(order_status = 0,1,NULL)) as pendingOrders,
                (COUNT(if(order_status = 0,1,NULL))*100)/COUNT(1) as percentagePendingOrders,
                COUNT(if(order_status = 1,1,NULL)) as processedOrders,
                (COUNT(if(order_status = 1,1,NULL))*100)/COUNT(1) as percentageProcessedOrders,
                COUNT(if(order_status = 2,1,NULL)) as dispatchedOrder,
                (COUNT(if(order_status = 2,1,NULL))*100)/COUNT(1) as percentageDispatchedOrder,
                COUNT(if(order_status = 3,1,NULL)) as deliveredOrder,
                (COUNT(if(order_status = 3,1,NULL))*100)/COUNT(1) as percentageDeliveredOrder,
                COUNT(if(order_status = 4,1,NULL)) as canceledOrder,
                (COUNT(if(order_status = 4,1,NULL))*100)/COUNT(1) as percentageCanceledOrder"))
                ->first();

            $paymentDetails = (array) DB::table('order_detail')
                ->join('order_amount_detail','order_detail.order_detail_id','=','order_amount_detail.order_detail_id')
                ->select(DB::raw("SUM(order_amount_detail.total_pay_cost) as allPayments,
                 SUM(if(order_detail.payment_status = 0,order_amount_detail.total_pay_cost,0)) as pendingPayment,
                 (SUM(if(order_detail.payment_status = 0,order_amount_detail.total_pay_cost,0))*100)/SUM(order_amount_detail.total_pay_cost) as percentagePendingPayment,
                 SUM(if(order_detail.payment_status = 1,order_amount_detail.total_pay_cost,0)) as successPayment,
                 (SUM(if(order_detail.payment_status = 1,order_amount_detail.total_pay_cost,0))*100)/SUM(order_amount_detail.total_pay_cost) as percentageSuccessPayment,
                 SUM(if(order_detail.payment_status = 2,order_amount_detail.total_pay_cost,0)) as failedPayment,
                 (SUM(if(order_detail.payment_status = 2,order_amount_detail.total_pay_cost,0))*100)/SUM(order_amount_detail.total_pay_cost) as percentageFailedPayment,
                 SUM(if(order_detail.payment_status = 3,order_amount_detail.total_pay_cost,0)) as returnedPayment,
                 (SUM(if(order_detail.payment_status = 3,order_amount_detail.total_pay_cost,0))*100)/SUM(order_amount_detail.total_pay_cost) as percentageReturnedPayment
                "))
                ->first();
            return array_merge($userDetails,$productDetails,$orderDetails,$paymentDetails);
        } catch (\Exception $e) {
            return array();
        }
    }


} // End of Class
