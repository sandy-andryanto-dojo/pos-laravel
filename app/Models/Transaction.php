<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

// Config

use OwenIt\Auditing\Contracts\Auditable;

use App\Traits\DataTable;

use DB;

// Relations

use App\Models\Supplier;

use App\Models\Customer;

use App\Models\User;

use App\Models\TransactionDetail;





class Transaction extends Model implements Auditable{



    use SoftDeletes, \OwenIt\Auditing\Auditable, DataTable;



    const SUPPLY = 0;

    const SALES = 1;

    const UNPAID = 0;

    const PAID = 1;



    private $type;

        

    protected $dates = ['deleted_at'];

	protected $table = 'transactions';

    protected $fillable = [

        'type',

        'status',

        'invoice_number',

        'invoice_date',

        'supplier_id',

        'customer_id',

        'casheir_id',

        'total_items',

        'subtotal',

        'discount',

        'tax',

        'grandtotal',

        'cash',

        'change',

        'notes'

    ];



    public function Supplier(){

        return $this->belongsTo(Supplier::class, "supplier_id");

    }



    public function Customer(){

        return $this->belongsTo(Customer::class, "customer_id");

    }



    public function Casheir(){

        return $this->belongsTo(User::class, "casheir_id");    

    }



    public function TransactionDetail() {

        return $this->hasMany(TransactionDetail::class);

    }



    public static function createInvoiceNumber($type){

        $code = $type == self::SUPPLY ? "PRCH" : "SALE";

        $sql = "SELECT MAX(invoice_number) as max_number FROM transactions WHERE type = ".$type." AND invoice_date =  DATE(now())";

        $data = DB::select($sql);

        if(!is_null($data) && isset($data[0]->max_number)){

            $arr = explode(".", $data[0]->max_number);

            $val = (int) $arr[2] + 1;

            $digit = 5;

            $i_number = strlen($val);

            for ($i = $digit; $i > $i_number; $i--) {

                $val = "0" . $val;

            }

            return $code.".".date("Ymd").".".$val;

        }

        return $code.".".date("Ymd").".00001";

    }



    public function selectData($actions){

        return [

            'transactions.invoice_number as transactions_invoice_number',

            'transactions.invoice_date as transactions_invoice_date',

            'transactions.status as transactions_status',

            'customers.name as customers_name',

            'suppliers.name as suppliers_name',

            'transactions.grandtotal as transactions_grandtotal',

            'transactions.id as key_id',

            DB::raw("'".$actions."' as actions")

        ];

    }



    public function dataTableQuery(){

        $type = $this->getType();

        return self::where($this->table.".id", "<>", 0)

            ->where($this->table.".type", $type)

            ->leftJoin("customers","customers.id","transactions.customer_id")

            ->leftJoin("suppliers","suppliers.id","transactions.supplier_id");

    }



    public function purhcaseByPeriode($firstDate, $lastDate){

        return self::where("type", 0)

            ->where("status", 1)

            ->whereDate("transactions.created_at", ">=", $firstDate)

            ->whereDate("transactions.created_at", "<=", $lastDate)

            ->orderBy("id", "DESC")

            ->get();

    }



    public function purchaseBySupplier($firstDate, $lastDate){

        $sql = "

            SELECT 

                suppliers.id as supplier_id,

                suppliers.name as supplier_name,

                IFNULL(SUM(qty), 0) as total_buy,

                IFNULL(SUM(total),0) as total_purchase

            FROM 

            suppliers

            LEFT JOIN transactions ON transactions.supplier_id = suppliers.id

            LEFT JOIN transactions_details ON transactions.id = transactions_details.transaction_id

            WHERE transactions.deleted_at IS NULL AND suppliers.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 0

            GROUP BY suppliers.id, suppliers.name ORDER BY suppliers.name

        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        return DB::select($str);        

    }



    public function purchaseByproduct($firstDate, $lastDate){

        $sql = "

            SELECT 

                brands.name as brand_name,

                types.name as type_name,

                products.sku as product_sku,

                products.name as product_name,

                suppliers.name as supplier_name,

                SUM(qty) as total_buy,

                SUM(total) as total_purchase

            FROM products

            LEFT JOIN transactions_details ON transactions_details.product_id = products.id

            LEFT JOIN transactions ON transactions.id = transactions_details.transaction_id

            LEFT JOIN brands ON brands.id = products.brand_id

            LEFT JOIN types ON types.id = products.type_id

            LEFT JOIN suppliers ON suppliers.id = products.supplier_id

            WHERE transactions.deleted_at IS NULL AND products.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 0

            GROUP BY brands.name, types.name, products.sku, products.name, suppliers.name ORDER BY brands.name, types.name, suppliers.name, products.sku, products.name 



        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        return DB::select($str);        

    }



    public function saleByPeriode($firstDate, $lastDate){

        return self::where("type", 1)

            ->where("status", 1)

            ->whereDate("transactions.created_at", ">=", $firstDate)

            ->whereDate("transactions.created_at", "<=", $lastDate)

            ->orderBy("id", "DESC")

            ->get();

    }



    public function saleByCustomer($firstDate, $lastDate){

        $sql = "

            SELECT 

                customers.id as customer_id,

                customers.name as customer_name,

                IFNULL(SUM(qty), 0) as total_sell,

                IFNULL(SUM(total),0) as total_sale

            FROM 

            customers

            LEFT JOIN transactions ON transactions.customer_id = customers.id

            LEFT JOIN transactions_details ON transactions.id = transactions_details.transaction_id

            WHERE transactions.deleted_at IS NULL AND customers.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 1

            GROUP BY customers.id, customers.name ORDER BY customers.name

        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        return DB::select($str);        

    }



    public function saleByproduct($firstDate, $lastDate){

        $sql = "

            SELECT 

                brands.name as brand_name,

                types.name as type_name,

                products.sku as product_sku,

                products.name as product_name,

                SUM(qty) as total_sell,

                SUM(total) as total_sale

            FROM products

            LEFT JOIN transactions_details ON transactions_details.product_id = products.id

            LEFT JOIN transactions ON transactions.id = transactions_details.transaction_id

            LEFT JOIN brands ON brands.id = products.brand_id

            LEFT JOIN types ON types.id = products.type_id

            WHERE transactions.deleted_at IS NULL AND products.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 1

            GROUP BY products.id, brands.name, types.name, products.sku, products.name ORDER BY brands.name, types.name, products.sku, products.name 

        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        return DB::select($str);        

    }



    public function getPurchaseDashboard(){

        $firstDate = date("Y-01-01");

        $lastDate = date("Y-12-31");

        $sql = "

            SELECT 

                products.name as name,

                SUM(qty) as total

            FROM transactions_details 

            INNER JOIN products ON products.id = transactions_details.product_id

            INNER JOIN transactions ON transactions.id = transactions_details.transaction_id

            WHERE transactions.deleted_at IS NULL AND products.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 0

            GROUP BY products.id, products.name, qty

            ORDER BY qty DESC 

            LIMIT 10

        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        $data = DB::select($str);      

        return json_decode(json_encode($data), JSON_NUMERIC_CHECK);

    }



    public function getSaleDashboard(){

        $firstDate = date("Y-01-01");

        $lastDate = date("Y-12-31");

        $sql = "

            SELECT 

                products.name as name,

                SUM(qty) as total

            FROM transactions_details 

            INNER JOIN products ON products.id = transactions_details.product_id

            INNER JOIN transactions ON transactions.id = transactions_details.transaction_id

            WHERE transactions.deleted_at IS NULL AND products.deleted_at IS NULL 

            AND DATE(transactions.created_at) >= '".$firstDate."' AND DATE(transactions.created_at) <= '".$lastDate."' AND transactions.type = 1

            GROUP BY products.id, products.name, qty

            ORDER BY qty DESC 

            LIMIT 10

        ";

        $str = trim(preg_replace('/\s+/', ' ', $sql));

        $data = DB::select($str);      

        return json_decode(json_encode($data), JSON_NUMERIC_CHECK);

    }



    public function getReportByYear($type){

        $year = (int) date("Y");

        $sql = "

            SELECT 'Jan' month, ".$year." year, 1 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 1 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Feb' month, ".$year." year, 2 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 2 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Mar' month, ".$year." year, 3 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 3 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Apr' month, ".$year." year, 4 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 4 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'May' month, ".$year." year, 5 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 5 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Jun' month, ".$year." year, 6 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 6 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Jul' month, ".$year." year, 7 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 7 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Aug' month, ".$year." year, 8 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 8 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Sep' month, ".$year." year, 9 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 9 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Oct' month, ".$year." year, 10 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 10 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Nov' month, ".$year." year, 11 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 11 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total UNION 

            SELECT 'Dec' month, ".$year." year, 12 monthOrder, (SELECT IFNULL(SUM(transactions.grandtotal),0) FROM transactions WHERE YEAR(created_at) = ".$year." AND MONTH(created_at) = 12 AND transactions.deleted_at IS NULL AND transactions.type = ".$type.") total  

        ";

        $query = trim(preg_replace('/\s+/', ' ', $sql));

        $result = DB::select($query);

        $items = array();

        foreach($result as $row){

            $items[] = (float) $row->total;

        }

        return $items;

    }



    /**

     * Get the value of type

     */ 

    public function getType()

    {

        return $this->type;

    }



    /**

     * Set the value of type

     *

     * @return  self

     */ 

    public function setType($type)

    {

        $this->type = $type;



        return $this;

    }

}