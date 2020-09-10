<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Override
//Route::post('/password/reset/');
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::any('/api/onefusion/voucher', 'OneFusionController@sendVoucher');


Route::group(['middleware' => ['auth', 'gcUserStatus', 'logs']], function () {


    Route::get('/', 'HomeController@index');
    Route::post('/api/get/logs', 'ActivityLogController@getReport');
    Route::get('/api/get/logs', 'ActivityLogController@getReport');



    Route::post('/api/business/add/agent', 'AngularAPIController@addAgentBusiness');

    Route::post('/api/client/get', 'AngularAPIController@getClients');
    Route::get('/api/clients/get/update', 'AngularAPIController@getUpdateClients');
    Route::post('/api/clients/update', 'AngularAPIController@updateClient');
    Route::post('/api/clients/add', 'AngularAPIController@addClient');
    Route::post('/api/client/transactions', 'AngularAPIController@getClientTransactions');
    Route::post('/api/client/resetPin', 'AngularAPIController@resetPin');
    Route::post('/api/client/settle', 'AngularAPIController@settleClient');
    Route::get('/api/client/number', 'AngularAPIController@getClientNumber');


    Route::get('/api/reports/get_transactions', 'AngularAPIController@getTransactions');

    Route::get('/api/devices/get_devices', 'AngularAPIController@getDevices');
    Route::post('/api/devices/delete', 'AngularAPIController@deleteDevice');
    Route::get('/api/devices/get_pending_devices', 'AngularAPIController@getPendingDevices');
    Route::get('/api/devices/get_filter_devices', 'AngularAPIController@getDevicesFilter');
    Route::post('/api/devices/add_device', 'AngularAPIController@addDevice');
    Route::post('/api/device/add_csv', 'AngularAPIController@addDeviceCsv');
    Route::get('/api/devices/stats', 'AngularAPIController@getDeviceStats');

    Route::get('/api/e_value/pending', 'AngularAPIController@getPendingEValueTransactions');
    Route::post('/api/e_value/validate', 'AngularAPIController@validateEvalueTransaction');
    Route::post('/api/e_value/initiate', 'AngularAPIController@initiateEvalueTransaction');
    Route::post('/api/banks_transfer/initiate', 'AngularAPIController@initiateBankTransaction');
    Route::get('/api/banks_transfer/pending', 'AngularAPIController@getPendingBankTransfers');
    Route::post('/api/banks_transfer/validate', 'AngularAPIController@validatePendingBankTransfers');



    Route::get('/api/users_all', 'AdminController@getAllUsers');

    Route::get('/api/users/all', 'AdminController@getUsers');

    Route::post('/api/users/approve', 'AdminController@approvePending');
    Route::post('/api/users/delete_pending', 'AdminController@deletePending');

    Route::get('/home', 'HomeController@index'); //Protected by auth. Might add more middleware for page to display
    Route::get('/register/success', 'HomeController@registrationSuccess');

    Route::get('/api/billers/get_billers', 'AngularAPIController@getBillers');
    Route::post('/api/billers/delete/', 'AngularAPIController@deleteBiller');
    Route::post('/api/billers/update/', 'AngularAPIController@updateBiller');

    Route::get('/api/products/get_products/', 'AngularAPIController@getProducts');
    Route::get('/api/billers/add_biller/{billerName}/{billerAddress}/{billerMobile}/{billerEmail}/{billerLandline}', 'AngularAPIController@addBiller');
    Route::get('/api/billers/stats', 'AngularAPIController@getBillerStats');
    Route::post('/api/billers/transactions', 'AngularAPIController@getBillerTransactions');

    Route::post('/api/product/transactions', 'AngularAPIController@getProductTransactions');
    Route::post('/api/products/update/', 'AngularAPIController@updateProduct');
    Route::post('/api/products/add_product/', 'AngularAPIController@addProduct');
    Route::post('/api/products/deactivate/', 'AngularAPIController@deactivateProduct');
    Route::post('/api/products/settle', 'AngularAPIController@settleProduct');
    Route::post('/api/products/add_data', 'AngularAPIController@addProductData');

//************

    Route::get('/api/bank/get', 'AngularAPIController@getBanks');
    Route::post('/api/bank/add', 'AngularAPIController@addBank');
    Route::post('/api/bank/update', 'AngularAPIController@updateBank');
    Route::post('/api/bank/delete', 'AngularAPIController@deleteBank');

    Route::get('/api/feesandcommission/get', 'AngularAPIController@getFeesandCommission');

    Route::get('/api/classofservice/get', 'AngularAPIController@getClassOfService');

    Route::post('/api/classofservice/add/client', 'AngularAPIController@addClientClassOfService');
    Route::post('/api/classofservice/add/business', 'AngularAPIController@addBusinessClassOfService');
    Route::post('/api/classofservice/add/bank', 'AngularAPIController@addBankClassOfService');

    Route::get('/api/business/get', 'AngularAPIController@getBusiness');
    Route::post('/api/business/add/agent', 'AngularAPIController@addAgentBusiness');
    Route::post('/api/business/update', 'AngularAPIController@updateBusiness');
    Route::post('/api/business/add/merchant', 'AngularAPIController@addMerchantBusiness');
    Route::post('/api/business/deactivate', 'AngularAPIController@deleteBusiness');
    Route::post('/api/business/close', 'AgentController@closeAgentAccount');

    Route::post('/api/business/devices', 'AngularAPIController@getBusinessDevices');

    Route::post('/api/business/assign/device', 'AngularAPIController@assignDeviceToAgent');
    Route::post('/api/business/assign/employee', 'AngularAPIController@assignEmployeeToAgent');
    Route::post('/api/business/employees', 'AngularAPIController@getBusinessEmployees');
    Route::post('/api/business/transactions', 'AngularAPIController@getBusinessTransactions');
    Route::post('/api/business/commissions/settle', 'AngularAPIController@settleBusinessCommissions');
    Route::post('/api/business/web-access', 'AngularAPIController@grantWebAccess');

    Route::post('/api/employee/activate', 'AngularAPIController@activateEmployee');
    Route::post('/api/employee/deactivate', 'AngularAPIController@deactivateEmployee');


    Route::get('/api/business/supervisor/get', 'AngularAPIController@getAgentSupervisor');
    Route::post('/api/business/supervisor/add', 'AngularAPIController@addAgentSupervisor');
    Route::post('/api/business/supervisor/update', 'AngularAPIController@updateAgentSupervisor');


    Route::post('/api/business/supervisor/delete', 'AngularAPIController@deleteAgentSupervisor');


    Route::get('/api/accounting/summary-of-balances', 'AngularAPIController@getSummaryOfBalances');
    Route::post('/api/accounting/closing-balances', 'AngularAPIController@getClosingBalances');
    Route::post('/api/accounting/bands', 'AngularAPIController@getTransactionBands');
    Route::post('/api/accounting/bands/products', 'AngularAPIController@getTransactionBandsProducts');
    Route::post('/api/accounting/bands/commissions', 'AngularAPIController@getTransactionBandsCommissions');
    Route::post('/api/accounting/statement-of-accounts', 'AngularAPIController@getStatementOfAccounts');


    Route::get('/api/products/add_product/', 'AngularAPIController@addProduct');

    Route::get('/api/transaction_type/get', 'AngularAPIController@getTransactionType');
    Route::post('/api/transaction/search', 'AngularAPIController@searchTransaction');
    Route::post('/api/transaction/reverse', 'AngularAPIController@reverseTransaction');

    Route::post('/api/adjustment/initiate', 'AngularAPIController@initiateAdjustment');
    Route::post('/api/adjustment/validate', 'AngularAPIController@validateAdjustment');
    Route::post('/api/adjustment/reverse', 'AngularAPIController@rejectAdjustment');
    Route::get('/api/adjustment/get-pending', 'AngularAPIController@getPendingAdjustment');


    Route::post('/fees-and-commissions/add', 'AngularAPIController@addFeesandCommissions');
    Route::post('api/settings/transactional-limits/add', 'AngularAPIController@addTransactionalLimits');

    Route::get('/api/activity/logs', 'ActivityLogController@getReport');
    Route::post('/api/activity/logs', 'ActivityLogController@getReport');


    Route::get('/api/reports/subscribers', 'AngularAPIController@getSubscriberReports');
    Route::any('/api/reports/subscribers/products', 'DashboardController@getSubscriberProductReports');
    Route::any('/api/reports/subscribers/p2p', 'DashboardController@getSubscriberP2PReports');
    Route::get('/api/reports/agents', 'AngularAPIController@getAgentReports');
    Route::get('/api/reports/agents/products', 'DashboardController@getAgentProductReports');
    Route::get('/api/reports/products', 'AngularAPIController@getProductsReports');
    Route::get('/api/reports/billers', 'DashboardController@getBillerGeneralReports');
    Route::get('/api/reports/devices', 'DashboardController@getDeviceGeneralReports');
    Route::get('/api/reports/zesa', 'DashboardController@getZesaSales');
    Route::get('/api/reports/econet', 'DashboardController@getEconetSales');
    Route::get('/api/reports/netone', 'DashboardController@getNetoneSales');
    Route::get('/api/reports/telecel', 'DashboardController@getTelecelSales');
    Route::get('/api/reports/zol', 'DashboardController@getZolSales');
    Route::get('/api/reports/clients', 'DashboardController@getClients');
    Route::get('/api/reports/powertelMobile', 'DashboardController@getPowertelMobile');
    Route::get('/api/reports/powertelAccount', 'DashboardController@getPowertelAccount');
    Route::get('/api/reports/insurance', 'DashboardController@getInsurance');
    Route::get('/api/reports/city-councils', 'DashboardController@getCityCouncils');
    Route::get('/api/reports/cashin', 'DashboardController@getCashIns');
    Route::get('/api/reports/cashout', 'DashboardController@getCashOuts');
    Route::get('/api/reports/sendmoney', 'DashboardController@getSendMoney');
    Route::post('/api/reports/rank', 'RankingsController@rankAgents');
    Route::get('/api/reports/excel', 'RankingsController@excelTest');

});

Route::group(['middleware' => ['auth', 'gcUserStatus', 'gcAdmin', 'logs']], function () {

    Route::get('/accounting/adjustments', 'AccountingController@getAdjustment');

    Route::get('/settings/admin/roles/configuration', 'SettingsController@getRoleConfiguration');

    /*Route::post('/fees-and-commissions/add', function (Request $request){
        echo 'toto';
    });*/


    //Clients
    Route::get('/client/list', 'ClientController@getListClient');
    Route::get('/client/update', 'ClientController@getUpdateClient');
    Route::get('/client/bulkadd', 'ClientController@bulkAddClients');
    Route::get('/client/add', 'ClientController@getAddClient');
    Route::post('/client/validate', 'ClientController@bulkValidate');
    Route::get('/client/exporttemplate', 'ClientController@exportTemplate')->name('export');
    Route::post('/client/bulksubmit', 'ClientController@submitUsers')->name('bulksubmit');

    //Disbursement Functionality
    //*****************
    Route::get('/disbursements/bulkdisbursements', 'DisbursementsController@bulkAddDisbursements');
    Route::post('/disbursements/bulkvalidate', 'DisbursementsController@disbursementsValidate')->name('disebursmentsValidate');
    Route::post('/disbursements/submitdisbursements', 'DisbursementsController@submitDisbursements')->name('submitdisbursements');
    Route::get('/disbursements/exporttemplate', 'DisbursementsController@exportTemplate')->name('export');
    Route::post('/disbursments/approve', 'DisbursementsController@approve')->name('approve');
    Route::post('/disbursments/validate', 'DisbursementsController@validatePayment')->name('validatePayment');

    //Reports
    Route::get('/reports/transactions', 'ReportController@getListTransactions');
    Route::get('/reports/dashboard', 'DashboardController@getDashboard');
    Route::get('/reports/volumes', 'ReportController@getVolumes');
    Route::get('/reports/rankings', 'RankingsController@getRankings');
    Route::get('/reports/dormant-accounts', 'ReportController@getDormantAccounts');

    //Devices
    Route::get('/devices/view', 'DeviceController@getViewDevices');
    Route::get('/devices/add', 'DeviceController@getAddDevice');

    //Business
    Route::get('/business/add', 'BusinessController@getAddBusiness');
    Route::get('/business/view', 'BusinessController@getViewBusiness');
    Route::get('/business/supervisor/add', 'BusinessController@getAddSupervisor');
    Route::get('/business/supervisor/view', 'BusinessController@getViewSupervisor');
    Route::get('/business/validation/pending', 'BusinessController@getPendingValidations');
    Route::get('/business/validation/bank_transfer/pending', 'BusinessController@getPendingBankTransfers');

    //Products
    Route::get('/product/add', 'ProductController@getAddProduct');
    Route::get('/product/add-data/Netone', 'ProductController@getAddNetoneData');
    Route::get('/product/view', 'ProductController@viewProduct');

    //Accounting
    Route::get('/accounting/statement-of-accounts', 'AccountingController@getStatementOfAccounts');
    Route::get('/accounting/balance-summary', 'AccountingController@getBalanceSummary');
    Route::get('/accounting/reversal', 'AccountingController@getReversal');
    Route::get('/accounting/closing-balance', 'AccountingController@getClosingBalance');
    //Route::get('/accounting','');

    //Billers
    Route::get('/billers/add', 'BillersController@getAddBiller');
    Route::get('/billers/view', 'BillersController@viewBiller');

    //Banks
    Route::get('/bank/add', 'BankController@getAddBank');
    Route::get('/bank/view', 'BankController@getViewBank');

    //Admin
    Route::get('/admin/user/delete/{id}', 'AdminController@deleteUser');
    Route::get('/admin/users', 'AdminController@getAllUsers');
    Route::get('/admin/users/pending', 'AdminController@getPendingUsers');
    Route::post('/admin/users/terminate', 'AdminController@terminateEmployee');
    Route::get('/admin/users/terminated', 'AdminController@terminatedEmployees');
    Route::get('/admin/roles', 'AdminController@getAllRoles');
    Route::get('/admin/matrix/roles', 'AdminController@getRolesForMatrix');
    Route::get('/admin/elements', 'AdminController@getAllElements');
    Route::get('/admin/perms', 'AdminController@getAllPerms');
    Route::get('/admin/permission', 'AdminController@getAllPermissions');
    Route::get('/admin/user/attach_role', 'AdminController@userAttachRole');
    Route::get('/admin/user/detach_role', 'AdminController@userDetachRole');
    Route::get('/admin/role/create', 'AdminController@createRole');
    Route::get('/admin/role/delete/{id}', 'AdminController@deleteRole');
    Route::get('/admin/role/attach_permission', 'AdminController@roleAttachPerm');
    Route::get('/admin/role/detach_permission', 'AdminController@roleDetachPerm');
    Route::get('/admin/role/config_permissions', 'AdminController@roleConfigurePermissions');
    Route::get('/admin/permission/create', 'AdminController@createPermission');
    Route::get('/admin/permission/delete/{id}', 'AdminController@deletePermission');

    //Settings
    Route::get('/settings/view_admin', 'SettingsController@getViewAdmin');
    Route::get('/settings/view_admin/pending', 'SettingsController@getViewAdminPending');
    Route::get('/settings/view_roles', 'SettingsController@getRolesAdmin');
    Route::get('/settings/admin/roles/create', 'SettingsController@getCreateRole');
    Route::get('/settings/admin/perms/create', 'SettingsController@getCreatePerm');
    Route::get('/settings/classofservice/add', 'SettingsController@addClassofService');
    Route::get('/settings/view_admin/terminated', 'SettingsController@getViewAdminTerminated');
    Route::get('/settings/fees-and-commissions/add', 'SettingsController@getFeesAndCommissionsAdd');
    /*    Route::get('/settings/transactional-limits/add', 'SettingsController@getTransactionalLimitsAdd');*/

    //ui
    Route::get('/ui/element/all/', 'UiController@getElements');
    Route::get('/ui/element/create/{name}/', 'UiController@createElement');
    Route::get('/ui/element/delete/{id}', 'UiController@deleteElement');
    Route::get('/ui/element/add_role/{element_id}/{role_id}', 'UiController@addRole');
    Route::get('/ui/element/remove_role/{element_id}/{role_id}', 'UiController@removeRole');
    Route::get('/ui/element/add_permission/{element_id}/{permission_id}', 'UiController@addPermission');
    Route::get('/ui/element/get_roles/{element_id}', 'UiController@getRolesForElement');
    Route::get('/ui/element/get_roles2/{element_id}', 'UiController@getRolesUiElement');

    Route::get('/ui/element/get_urls/{element_id}', 'UiController@getUrlsElement');

    //url
    Route::get('/url/all/', 'UrlController@getUrls');
    Route::get('/url/add_role/{url_id}/{role_id}', 'UrlController@addRole');
    Route::get('/url/remove_role/{url_id}/{role_id}', 'UrlController@removeRole');
    Route::get('/url/add_permission/{url_id}/{permission_id}', 'UrlController@addPermission');
    Route::get('/url/get_roles/{url_id}', 'UrlController@getRolesForUrl');
    Route::get('/url/get_roles2/{url_id}', 'UrlController@getRolesUrl');


    //Activity Logs
    Route::get('/reports/activity-logs', 'SettingsController@getActivityLogs');
});
//************
