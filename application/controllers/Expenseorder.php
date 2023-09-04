<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Expenseorder extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Expensenorder_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

    // ****************************** View Page -- START ****************************** //

    // ****************************** View Page -- END ****************************** //

    // Create Return Order;
    public function create_expense()
    {
        $cust_id = $this->input->get('cust_id');
        $sales_id = $this->input->get('sales_id');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_dateformat = $settingData->datetime_format;

        $data['dateformat'] = $setting_dateformat;
        $data['tax'] = $settingData->tax;
        $data['currency'] = $settingData->currency;

        

        if (empty($sales_id)) {
            $data['url_sales_id'] = 0;
        } else {
            $data['url_sales_id'] = $sales_id;
        }

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_refund_amount'] = $this->lang->line('refund_amount');
        $data['lang_refund_tax'] = $this->lang->line('refund_tax');
        $data['lang_refund_grand_total'] = $this->lang->line('refund_grand_total');
        $data['lang_refund_by'] = $this->lang->line('refund_by');
        $data['lang_refund_method'] = $this->lang->line('refund_method');
        $data['lang_add_to_return_item_list'] = $this->lang->line('add_to_return_item_list');
        $data['lang_return_quantity'] = $this->lang->line('return_quantity');
        $data['lang_condition'] = $this->lang->line('condition');
        $data['lang_good'] = $this->lang->line('good');
        $data['lang_search_product_by_namecode'] = $this->lang->line('search_product_by_namecode');
        $data['lang_search_outlet'] = $this->lang->line('search_outlet');
        $data['lang_search_customer'] = $this->lang->line('search_customer');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_address'] = $this->lang->line('address');
        $data['lang_telephone'] = $this->lang->line('telephone');
        $data['lang_return_type_positive'] = $this->lang->line('return_type_positive');
        $data['lang_return_invoice_effect'] = $this->lang->line('return_invoice_effect');
        $data['lang_full_refund'] = $this->lang->line('full_refund');
        $data['lang_partial_refund'] = $this->lang->line('partial_refund');
        $data['lang_choose_refund_by'] = $this->lang->line('choose_refund_by');
        $data['lang_choose_refund_method'] = $this->lang->line('choose_refund_method');
        $data['lang_are_you_confirm_return'] = $this->lang->line('are_you_confirm_return');

        $this->load->view('create_expense', $data);
    }

    // Confirmation Return Order;
    public function confirmation()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');

        $return_id = $this->input->get('return_id');
        $site_date_format = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $data['return_id'] = $return_id;
        $data['site_dateformat'] = $site_date_format;
        $data['site_currency'] = $site_currency;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_refund_amount'] = $this->lang->line('refund_amount');
        $data['lang_refund_tax'] = $this->lang->line('refund_tax');
        $data['lang_refund_grand_total'] = $this->lang->line('refund_grand_total');
        $data['lang_refund_by'] = $this->lang->line('refund_by');
        $data['lang_refund_method'] = $this->lang->line('refund_method');
        $data['lang_add_to_return_item_list'] = $this->lang->line('add_to_return_item_list');
        $data['lang_return_quantity'] = $this->lang->line('return_quantity');
        $data['lang_condition'] = $this->lang->line('condition');
        $data['lang_good'] = $this->lang->line('good');
        $data['lang_search_product_by_namecode'] = $this->lang->line('search_product_by_namecode');
        $data['lang_search_outlet'] = $this->lang->line('search_outlet');
        $data['lang_search_customer'] = $this->lang->line('search_customer');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_address'] = $this->lang->line('address');
        $data['lang_telephone'] = $this->lang->line('telephone');
        $data['lang_return_type_positive'] = $this->lang->line('return_type_positive');
        $data['lang_return_invoice_effect'] = $this->lang->line('return_invoice_effect');
        $data['lang_full_refund'] = $this->lang->line('full_refund');
        $data['lang_partial_refund'] = $this->lang->line('partial_refund');
        $data['lang_choose_refund_by'] = $this->lang->line('choose_refund_by');
        $data['lang_choose_refund_method'] = $this->lang->line('choose_refund_method');
        $data['lang_are_you_confirm_return'] = $this->lang->line('are_you_confirm_return');
        $data['lang_return_order_confirmation'] = $this->lang->line('return_order_confirmation');
        $data['lang_print_return_order_receipt'] = $this->lang->line('print_return_order_receipt');
        $data['lang_not_good'] = $this->lang->line('not_good');

        $this->load->view('expense_confirmation', $data);
    }

    // Print Return;
    public function printReturn()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');

        $return_id = $this->input->get('return_id');
        $site_date_format = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $data['return_id'] = $return_id;
        $data['site_dateformat'] = $site_date_format;
        $data['site_currency'] = $site_currency;

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_refund_amount'] = $this->lang->line('refund_amount');
        $data['lang_refund_tax'] = $this->lang->line('refund_tax');
        $data['lang_refund_grand_total'] = $this->lang->line('refund_grand_total');
        $data['lang_refund_by'] = $this->lang->line('refund_by');
        $data['lang_refund_method'] = $this->lang->line('refund_method');
        $data['lang_add_to_return_item_list'] = $this->lang->line('add_to_return_item_list');
        $data['lang_return_quantity'] = $this->lang->line('return_quantity');
        $data['lang_condition'] = $this->lang->line('condition');
        $data['lang_good'] = $this->lang->line('good');
        $data['lang_search_product_by_namecode'] = $this->lang->line('search_product_by_namecode');
        $data['lang_search_outlet'] = $this->lang->line('search_outlet');
        $data['lang_search_customer'] = $this->lang->line('search_customer');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_address'] = $this->lang->line('address');
        $data['lang_telephone'] = $this->lang->line('telephone');
        $data['lang_return_type_positive'] = $this->lang->line('return_type_positive');
        $data['lang_return_invoice_effect'] = $this->lang->line('return_invoice_effect');
        $data['lang_full_refund'] = $this->lang->line('full_refund');
        $data['lang_partial_refund'] = $this->lang->line('partial_refund');
        $data['lang_choose_refund_by'] = $this->lang->line('choose_refund_by');
        $data['lang_choose_refund_method'] = $this->lang->line('choose_refund_method');
        $data['lang_are_you_confirm_return'] = $this->lang->line('are_you_confirm_return');
        $data['lang_return_order_confirmation'] = $this->lang->line('return_order_confirmation');
        $data['lang_print_return_order_receipt'] = $this->lang->line('print_return_order_receipt');
        $data['lang_not_good'] = $this->lang->line('not_good');
        $data['lang_code'] = $this->lang->line('code');

        $this->load->view('print_expense', $data);
    }

    // Return Report;
    public function expense_report()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;
        $data['site_currency'] = $siteSetting_currency;
        $data['dateformat'] = $dateformat;

        $data['lang_dashboard'] = $this->lang->line('dashboard');
        $data['lang_customers'] = $this->lang->line('customers');
        $data['lang_gift_card'] = $this->lang->line('gift_card');
        $data['lang_add_gift_card'] = $this->lang->line('add_gift_card');
        $data['lang_list_gift_card'] = $this->lang->line('list_gift_card');
        $data['lang_debit'] = $this->lang->line('debit');
        $data['lang_sales'] = $this->lang->line('sales');
        $data['lang_today_sales'] = $this->lang->line('today_sales');
        $data['lang_opened_bill'] = $this->lang->line('opened_bill');
        $data['lang_reports'] = $this->lang->line('reports');
        $data['lang_sales_report'] = $this->lang->line('sales_report');
        $data['lang_expenses'] = $this->lang->line('expenses');
        $data['lang_expenses_category'] = $this->lang->line('expenses_category');
        $data['lang_pnl'] = $this->lang->line('pnl');
        $data['lang_pnl_report'] = $this->lang->line('pnl_report');
        $data['lang_pos'] = $this->lang->line('pos');
        $data['lang_return_order'] = $this->lang->line('return_order');
        $data['lang_return_order_report'] = $this->lang->line('return_order_report');
        $data['lang_inventory'] = $this->lang->line('inventory');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_list_products'] = $this->lang->line('list_products');
        $data['lang_print_product_label'] = $this->lang->line('print_product_label');
        $data['lang_product_category'] = $this->lang->line('product_category');
        $data['lang_purchase_order'] = $this->lang->line('purchase_order');
        $data['lang_setting'] = $this->lang->line('setting');
        $data['lang_outlets'] = $this->lang->line('outlets');
        $data['lang_users'] = $this->lang->line('users');
        $data['lang_suppliers'] = $this->lang->line('suppliers');
        $data['lang_system_setting'] = $this->lang->line('system_setting');
        $data['lang_payment_methods'] = $this->lang->line('payment_methods');
        $data['lang_logout'] = $this->lang->line('logout');
        $data['lang_point_of_sales'] = $this->lang->line('point_of_sales');
        $data['lang_amount'] = $this->lang->line('amount');
        $data['lang_monthly_sales_outlet'] = $this->lang->line('monthly_sales_outlet');
        $data['lang_no_match_found'] = $this->lang->line('no_match_found');
        $data['lang_create_return_order'] = $this->lang->line('create_return_order');

        $data['lang_action'] = $this->lang->line('action');
        $data['lang_edit'] = $this->lang->line('edit');
        $data['lang_status'] = $this->lang->line('status');
        $data['lang_add'] = $this->lang->line('add');
        $data['lang_back'] = $this->lang->line('back');
        $data['lang_update'] = $this->lang->line('update');
        $data['lang_active'] = $this->lang->line('active');
        $data['lang_inactive'] = $this->lang->line('inactive');
        $data['lang_name'] = $this->lang->line('name');
        $data['lang_search_product'] = $this->lang->line('search_product');
        $data['lang_add_to_list'] = $this->lang->line('add_to_list');
        $data['lang_submit'] = $this->lang->line('submit');
        $data['lang_receive'] = $this->lang->line('receive');
        $data['lang_view'] = $this->lang->line('view');
        $data['lang_created'] = $this->lang->line('created');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_discount_amount'] = $this->lang->line('discount_amount');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_totat_payable'] = $this->lang->line('totat_payable');
        $data['lang_discount'] = $this->lang->line('discount');
        $data['lang_sale_id'] = $this->lang->line('sale_id');
        $data['lang_tax_total'] = $this->lang->line('tax_total');
        $data['lang_export_to_excel'] = $this->lang->line('export_to_excel');

        $data['lang_product_name'] = $this->lang->line('product_name');
        $data['lang_product_code'] = $this->lang->line('product_code');
        $data['lang_remark'] = $this->lang->line('remark');
        $data['lang_refund_amount'] = $this->lang->line('refund_amount');
        $data['lang_refund_tax'] = $this->lang->line('refund_tax');
        $data['lang_refund_grand_total'] = $this->lang->line('refund_grand_total');
        $data['lang_refund_by'] = $this->lang->line('refund_by');
        $data['lang_refund_method'] = $this->lang->line('refund_method');
        $data['lang_add_to_return_item_list'] = $this->lang->line('add_to_return_item_list');
        $data['lang_return_quantity'] = $this->lang->line('return_quantity');
        $data['lang_condition'] = $this->lang->line('condition');
        $data['lang_good'] = $this->lang->line('good');
        $data['lang_search_product_by_namecode'] = $this->lang->line('search_product_by_namecode');
        $data['lang_search_outlet'] = $this->lang->line('search_outlet');
        $data['lang_search_customer'] = $this->lang->line('search_customer');
        $data['lang_previous_sales'] = $this->lang->line('previous_sales');
        $data['lang_customer'] = $this->lang->line('customer');
        $data['lang_per_item_price'] = $this->lang->line('per_item_price');
        $data['lang_total_items'] = $this->lang->line('total_items');
        $data['lang_sub_total'] = $this->lang->line('sub_total');
        $data['lang_grand_total'] = $this->lang->line('grand_total');
        $data['lang_paid_amt'] = $this->lang->line('paid_amt');
        $data['lang_return_change'] = $this->lang->line('return_change');
        $data['lang_paid_by'] = $this->lang->line('paid_by');
        $data['lang_date'] = $this->lang->line('date');
        $data['lang_products'] = $this->lang->line('products');
        $data['lang_quantity'] = $this->lang->line('quantity');
        $data['lang_total'] = $this->lang->line('total');
        $data['lang_tax'] = $this->lang->line('tax');
        $data['lang_address'] = $this->lang->line('address');
        $data['lang_telephone'] = $this->lang->line('telephone');
        $data['lang_return_type_positive'] = $this->lang->line('return_type_positive');
        $data['lang_return_invoice_effect'] = $this->lang->line('return_invoice_effect');
        $data['lang_full_refund'] = $this->lang->line('full_refund');
        $data['lang_partial_refund'] = $this->lang->line('partial_refund');
        $data['lang_choose_refund_by'] = $this->lang->line('choose_refund_by');
        $data['lang_choose_refund_method'] = $this->lang->line('choose_refund_method');
        $data['lang_are_you_confirm_return'] = $this->lang->line('are_you_confirm_return');
        $data['lang_return_order_confirmation'] = $this->lang->line('return_order_confirmation');
        $data['lang_print_return_order_receipt'] = $this->lang->line('print_return_order_receipt');
        $data['lang_not_good'] = $this->lang->line('not_good');
        $data['lang_choose_paid_by'] = $this->lang->line('choose_paid_by');
        $data['lang_start_date'] = $this->lang->line('start_date');
        $data['lang_end_date'] = $this->lang->line('end_date');
        $data['lang_get_report'] = $this->lang->line('get_report');
        $data['lang_all_outlets'] = $this->lang->line('all_outlets');
        $data['lang_all'] = $this->lang->line('all');

        $data['lang_choose_outlet'] = $this->lang->line('choose_outlet');

        $this->load->view('expense_report', $data);
    }

    // ****************************** Action To Database -- START ****************************** //

    // Submit;
    public function insertReturnOrder()
    {
        
        $outlet = $this->input->post('outlet');
        $remark = $this->input->post('remark');

        $refund_amt = $this->input->post('refund_amt');
        $refund_tax = $this->input->post('refund_tax');
        $refund_grand = $this->input->post('refund_grand');

        $refund_by = $this->input->post('refund_by');
        $cheque_numb = $this->input->post('cheque_numb');
        $refund_method = $this->input->post('refund_method');

        $row_count = $this->input->post('row_count');

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        

        $outletDtaData = $this->Constant_model->getDataOneColumn('outlets', 'id', $outlet);
        $outlet_name = $outletDtaData[0]->name;
        $outlet_address = $outletDtaData[0]->address;
        $outlet_contact = $outletDtaData[0]->contact_number;
        $outlet_footer = $outletDtaData[0]->receipt_footer;

        

        
            $ins_order_data = array(
                    
                    'ordered_datetime' 		=> 	$tm,
                    'outlet_id' 			=> 	$outlet,
                    'outlet_name' 			=> 	$outlet_name,
                    'outlet_address' 		=> 	$outlet_address,
                    'outlet_contact' 		=> 	$outlet_contact,
                    'outlet_receipt_footer' => 	$outlet_footer,
                    "gift_card"				=>	"",
                    'subtotal' 				=> 	'-'.$refund_amt,
                    'discount_total' 		=> 	'0',
                    "discount_percentage"	=>	"",
                    'tax' 					=> 	'-'.$refund_tax,
                    'grandtotal' 			=> 	'-'.$refund_grand,
                   
                    'paid_amt' 				=> 	'-'.$refund_amt,
                    "return_change"			=>	"0",
                    'created_user_id' 		=> 	$us_id,
                    'created_datetime' 		=> 	$tm,
                    "updated_user_id"		=>	"0",
                    "updated_datetime"		=>	"0000-00-00 00:00:00",
                    'vt_status' 			=> 	'1',
                    'status'		 		=> 	'2',
                    
                    'remark' 				=> 	$remark,
                    "card_number"			=>	""
            );
            $order_id = $this->Constant_model->insertDataReturnLastId('orders', $ins_order_data);

            // Return Items -- START;
            for ($i = 1; $i < $row_count; ++$i) {
                $pcode = $this->input->post("pcode_$i");
                $qty = $this->input->post("qty_$i");
                $cond = $this->input->post("cond_$i");

                if (!empty($pcode)) {
                    if ($qty > 0) {
                        $cond_status = '';
                        if ($cond == 'on') {
                            $cond_status = '1';
                        } else {
                            $cond_status = '2';
                        }

                        $price = 0;
                        $prodDtaData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);
                        if (count($prodDtaData) == 1) {
                            $price = $prodDtaData[0]->retail_price;
                        }

                        $ins_return_item_data = array(
                                  'order_id' => $order_id,
                                  'product_code' => $pcode,
                                  'price' => $price,
                                  'qty' => $qty,
                                  'item_condition' => $cond_status,
                        );
                        $this->Constant_model->insertData('return_items', $ins_return_item_data);

                        // Inventory Update -- START ;
                        if ($cond_status == '1') {
                            $getInvDtaResult = $this->db->query("SELECT * FROM inventory WHERE product_code = '$pcode' AND outlet_id = '$outlet' ");
                            $getInvDtaRows = $getInvDtaResult->num_rows();
                            if ($getInvDtaRows == 1) {
                                $getInvDtaData = $getInvDtaResult->result();

                                $getInv_id = $getInvDtaData[0]->id;
                                $getInv_qty = $getInvDtaData[0]->qty;

                                unset($getInvDtaData);

                                $upd_inv_qty = 0;
                                $upd_inv_qty = $getInv_qty + $qty;

                                $upd_data = array(
                                            'qty' => $upd_inv_qty,
                                );
                                $this->Constant_model->updateData('inventory', $upd_data, $getInv_id);
                            } else {
                                $ins_data = array(
                                        'product_code' => $pcode,
                                        'outlet_id' => $outlet,
                                        'qty' => $qty,
                                );
                                $last_inv_id = $this->Constant_model->insertDataReturnLastId('inventory', $ins_data);
                            }
                        }
                        // Inventory Update -- END;
                    }
                }
            }
            // Return Items -- END;

             $this->session->set_flashdata('alert_msg', array('success', 'Expense Order', 'Successfully Created Expense Order.'));
            redirect(base_url().'expenseorder/confirmation?return_id='.$order_id);
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    

    // ****************************** Export to Excel -- START ****************************** //

