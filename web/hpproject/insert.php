<html>
<head>
  <title>Insert</title>
</head>



<?php
require 'header.php';
require 'functions.php';

//FIX!!!!!
//Fix Scanner-confirmation modal


//Queries
$custType = $db->prepare('SELECT unnest(enum_range(NULL::customerType)) AS name');
$custType->execute();

$custRegion = $db->prepare('SELECT unnest(enum_range(NULL::regions)) AS region');
$custRegion->execute();
$regions = $custRegion->fetchAll();

$empType = $db->prepare('SELECT unnest(enum_range(NULL::employeeType)) AS name');
$empType->execute();

$prinClass = $db->prepare('SELECT unnest(enum_range(NULL::deviceClass)) AS class');
$prinClass->execute();
$classes = $prinClass->fetchAll();

$prinFirm = $db->prepare('SELECT unnest(enum_range(NULL::firmwareType)) AS firm');
$prinFirm->execute();
$firmware = $prinFirm->fetchAll();

$solutionType = $db->prepare('SELECT unnest(enum_range(NULL::solutionType)) AS type');
$solutionType->execute();

$cust = $db->prepare('SELECT name FROM customer');
$cust->execute();
$customers = $cust->fetchAll();

$princ = $db->prepare('SELECT model_name as name FROM printer');
$princ->execute();
$printers = $princ->fetchAll();

$scan = $db->prepare('SELECT model_name as name FROM scanner');
$scan->execute();
$scanners = $scan->fetchAll();

$sol = $db->prepare('SELECT name FROM solution');
$sol->execute();
$solutions = $sol->fetchAll();

$emp = $db->prepare('SELECT name FROM employee');
$emp->execute();
$employees = $emp->fetchAll();

$loc = $db->prepare('SELECT * FROM location');
$loc->execute();
$locations = $loc->fetchAll();

//Inserts into DB

//Customer Insert
if (isset($_POST['cname']))
{
    $cname = emptyToNull($_POST['cname']);
    $insert = $db->prepare('INSERT INTO customer VALUES
                            (
                                DEFAULT,
                                :name,
                                :phone,
                                :region,
                                :type,
                                :notes
                            )');
      $insert->bindValue(':name',emptyToNull($_POST['cname']),PDO::PARAM_STR);
      $insert->bindValue(':phone',emptyToNull($_POST['cphone']),PDO::PARAM_STR);
      $insert->bindValue(':region',emptyToNull($_POST['cregion']),PDO::PARAM_STR);
      $insert->bindValue(':type',emptyToNull($_POST['ctype']),PDO::PARAM_STR);
      $insert->bindValue(':notes',emptyToNull($_POST['cnotes']),PDO::PARAM_STR);

      insert($insert); 
}

  //Employee Insert
  if (isset($_POST['ename']))
  {
      $passwordHash = password_hash(emptyToNull($_POST['epassword']),PASSWORD_DEFAULT);

      $insert = $db->prepare('INSERT INTO employee VALUES
                              (
                                  DEFAULT,
                                  :name,
                                  :email,
                                  :password,
                                  :type,
                                  :region
                              )');
      $insert->bindValue(':name',emptyToNull($_POST['ename']),PDO::PARAM_STR);
      $insert->bindValue(':email',emptyToNull($_POST['eemail']),PDO::PARAM_STR);
      $insert->bindValue(':password',$passwordHash,PDO::PARAM_STR);
      $insert->bindValue(':type',emptyToNull($_POST['etype']),PDO::PARAM_STR);
      $insert->bindValue(':region',emptyToNull($_POST['eregion']),PDO::PARAM_STR);
      
      insert($insert); 
  }

  //Printer Insert
  if (isset($_POST['pname']))
  {
      $insert = $db->prepare('INSERT INTO printer VALUES
                              (
                                  DEFAULT,
                                  :modelName,
                                  :class,
                                  :firm,
                                  :mfp,
                                  :color,
                                  :duplex,
                                  :supports_sm,
                                  :sm_inst_on_cap,
                                  :sure_start,
                                  :whitelisting,
                                  :run_time_int_det,
                                  :connection_inspector,
                                  :is_a4
                              )');
      $insert->bindValue(':modelName',emptyToNull($_POST['pname']),PDO::PARAM_STR);
      $insert->bindValue(':class',emptyToNull($_POST['pclass']),PDO::PARAM_STR);
      $insert->bindValue(':firm',emptyToNull($_POST['pfirm']),PDO::PARAM_STR);
      $insert->bindValue(':mfp',emptyToNull($_POST['pmfp']),PDO::PARAM_STR);
      $insert->bindValue(':color',emptyToNull($_POST['pcolor']),PDO::PARAM_STR);
      $insert->bindValue(':duplex',emptyToNull($_POST['pduplex']),PDO::PARAM_STR);
      $insert->bindValue(':supports_sm',emptyToNull($_POST['psupports_sm']),PDO::PARAM_STR);
      $insert->bindValue(':sm_inst_on_cap',emptyToNull($_POST['psm_inst_on_cap']),PDO::PARAM_STR);
      $insert->bindValue(':sure_start',emptyToNull($_POST['psure_start']),PDO::PARAM_STR);
      $insert->bindValue(':whitelisting',emptyToNull($_POST['pwhitelisting']),PDO::PARAM_STR);
      $insert->bindValue(':run_time_int_det',emptyToNull($_POST['prun_time_int_det']),PDO::PARAM_STR);
      $insert->bindValue(':connection_inspector',emptyToNull($_POST['pconnection_inspector']),PDO::PARAM_STR);
      $insert->bindValue(':is_a4',emptyToNull($_POST['pis_a4']),PDO::PARAM_STR);

      insert($insert);
  }


  //Solution Inserts
  if (isset($_POST['soname'])) {
     $insert = $db->prepare('INSERT INTO solution VALUES
                             (
                                DEFAULT,
                                :name,
                                :type
                             )');
     $insert->bindValue(':name',emptyToNull($_POST['soname']), PDO::PARAM_STR);
     $insert->bindValue(':type',emptyToNull($_POST['sotype']), PDO::PARAM_STR);

    insert($insert);
  }

  //Scanner Inserts
  if (isset($_POST['scname'])) {
    $insert = $db->prepare('INSERT INTO scanner VALUES
                            (
                              DEFAULT,
                              :name,
                              :class,
                              :firm,
                              :flatbed,
                              :adf,
                              :sheet_feed
                            )');
    $insert->bindValue(':name',emptyToNull($_POST['scname']),PDO::PARAM_STR);
    $insert->bindValue(':class',emptyToNull($_POST['scclass']),PDO::PARAM_STR);
    $insert->bindValue(':firm',emptyToNull($_POST['scfirm']),PDO::PARAM_STR);
    $insert->bindValue(':flatbed',emptyToNull($_POST['scflatbed']),PDO::PARAM_STR);
    $insert->bindValue(':adf',emptyToNull($_POST['scadf']),PDO::PARAM_STR);
    $insert->bindValue(':sheet_feed',emptyToNull($_POST['scsheet_feed']),PDO::PARAM_STR);
     
    insert($insert);
  }

  //Data Options Insert
  if (isset($_POST['doname'])) {
    if (emptyToNull($_POST['doname']) != NULL) {
      $insert = $db->prepare('ALTER TYPE ' . $_POST['dotype'] . ' ADD VALUE \'' . $_POST['doname'] . '\'');
    
      insert($insert);
    }
    else {
      echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
      $_SESSION['dbFail'] = true;
    }
  }

  //Customer-Printer Insert
  if (isset($_POST['cpcname'])) {
    $insert = $db->prepare('INSERT INTO customer_printer VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM customer WHERE name = :cname),
                              (SELECT id FROM printer WHERE model_name = :pname),
                              :qty,
                              :fs4,
                              :notes
                            )');
    $insert->bindValue(':cname',$_POST['cpcname'], PDO::PARAM_STR); //cname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':pname',$_POST['cppname'], PDO::PARAM_STR); //pname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':qty',emptyToNull($_POST['cpqty']), PDO::PARAM_INT);
    $insert->bindValue(':fs4',emptyToNull($_POST['cpfs4']), PDO::PARAM_STR);
    $insert->bindValue(':notes',emptyToNull($_POST['cpnotes']), PDO::PARAM_STR);

    insert($insert);
  }

  //Customer-Scanner Insert
  if (isset($_POST['cscname'])) {
    $insert = $db->prepare('INSERT INTO customer_scanner VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM customer WHERE name = :cname),
                              (SELECT id FROM scanner WHERE model_name = :sname),
                              :qty,
                              :fs4,
                              :notes
                            )');
    $insert->bindValue(':cname',$_POST['cscname'], PDO::PARAM_STR); //cname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':sname',$_POST['cssname'], PDO::PARAM_STR); //pname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':qty',emptyToNull($_POST['csqty']), PDO::PARAM_INT);
    $insert->bindValue(':fs4',emptyToNull($_POST['csfs4']), PDO::PARAM_STR);
    $insert->bindValue(':notes',emptyToNull($_POST['csnotes']), PDO::PARAM_STR);

    insert($insert);
  }

  //Customer-Solution Insert
  if (isset($_POST['csocname'])) {
    $insert = $db->prepare('INSERT INTO customer_solution VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM customer WHERE name = :cname),
                              (SELECT id FROM solution WHERE name = :sname),
                              :version,
                              :qty,
                              :notes
                            )');
    $insert->bindValue(':cname',$_POST['csocname'], PDO::PARAM_STR); //cname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':sname',$_POST['csosname'], PDO::PARAM_STR); //pname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':version',emptyToNull($_POST['csoversion']), PDO::PARAM_STR);
    $insert->bindValue(':qty',emptyToNull($_POST['csoqty']), PDO::PARAM_INT);
    $insert->bindValue(':notes',emptyToNull($_POST['csonotes']), PDO::PARAM_STR);

    insert($insert);
  }

  //Customer-Employee Insert
  if (isset($_POST['cecname'])) {
    $insert = $db->prepare('INSERT INTO customer_employee VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM customer WHERE name = :cname),
                              (SELECT id FROM employee WHERE name = :ename)
                            )');
    $insert->bindValue(':cname',$_POST['cecname'], PDO::PARAM_STR); //cname is actually an ID. Refer to value field on CP card.
    $insert->bindValue(':ename',$_POST['ceename'], PDO::PARAM_STR); //ename is actually an ID. Refer to value field on CP card.

    insert($insert);
  }

  //Customer-Contact Insert
  if (isset($_POST['cccname'])) {
    $insert = $db->prepare('INSERT INTO customer_contact VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM customer WHERE name = :cname),
                              :coname,
                              :title,
                              :location,
                              :email,
                              :business_phone,
                              :mobile_phone,
                              :main,
                              :notes
                            )');
    $insert->bindValue(':cname',emptyToNull($_POST['cccname']), PDO::PARAM_STR);
    $insert->bindValue(':coname', emptyToNull($_POST['ccconame']), PDO::PARAM_STR);
    $insert->bindValue(':title', emptyToNull($_POST['cctitle']), PDO::PARAM_STR);
    $insert->bindValue(':location', emptyToNull($_POST['cclocation']), PDO::PARAM_INT);
    $insert->bindValue(':email', emptyToNull($_POST['ccemail']), PDO::PARAM_STR);
    $insert->bindValue(':business_phone', emptyToNull($_POST['ccbusiness_phone']), PDO::PARAM_STR);
    $insert->bindValue(':mobile_phone', emptyToNull($_POST['ccmobile_phone']), PDO::PARAM_STR);
    $insert->bindValue(':main', emptyToNull($_POST['ccmain']), PDO::PARAM_STR);
    $insert->bindValue(':notes', emptyToNull($_POST['ccnotes']), PDO::PARAM_STR);

    insert($insert);
  }

  if (isset($_POST['laddress'])) {
    $insert = $db->prepare('INSERT INTO location VALUES
                            (
                              DEFAULT,
                              :address,
                              :city,
                              :state,
                              :zip,
                              :country
                            )');
    $insert->bindValue(':address',emptyToNull($_POST['laddress']));
    $insert->bindValue(':city',emptyToNull($_POST['lcity']));
    $insert->bindValue(':state',emptyToNull($_POST['lstate']));
    $insert->bindValue(':zip',emptyToNull($_POST['lzip']));
    $insert->bindValue(':country',emptyToNull($_POST['lcountry']));

    insert($insert);
  }

  //Customer-Location Insert
  if (isset($_POST['clcname'])) {
    $insert = $db->prepare('INSERT INTO customer_location VALUES
                            (
                              DEFAULT,
                              (SELECT id FROM CUSTOMER WHERE name = :cname),
                              :address
                            )');
    $insert->bindValue(':cname',emptyToNull($_POST['clcname']),PDO::PARAM_STR);
    $insert->bindValue(':address', emptyToNULL($_POST['claddress']), PDO::PARAM_INT);

    insert($insert);
  }

?>

<script>

//Prevent user from submitting form accidentally with Enter
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
  //Gets Data and Shows the Customer Modal
  function showCModal() {
    var name = document.getElementById("c-name").value;
    var phone = document.getElementById("c-phone").value;
    var region = $("#c-region :selected").text();
    var type = $("#c-type :selected").text(); 
    var notes = document.getElementById("c-notes").value;

    document.getElementById("c-conf-name").innerHTML = "Name: " + name;
    document.getElementById("c-conf-phone").innerHTML = "Phone: " + phone;
    document.getElementById("c-conf-region").innerHTML = "Region: " + region;
    document.getElementById("c-conf-type").innerHTML = "Type: " + type;
    document.getElementById("c-conf-notes").innerHTML = "Notes: " + notes;

    $('#confirmCustomer').modal('show');
  }

  //Gets Data and Shows Employee Modal
  function showEModal() {
    var name = document.getElementById("e-name").value;
    var email = document.getElementById("e-email").value;
    var region = $("#e-region :selected").text();
    var type = $("#e-type :selected").text(); 

    document.getElementById("e-conf-name").innerHTML = "Name: " + name;
    document.getElementById("e-conf-email").innerHTML = "Email: " + email;
    document.getElementById("e-conf-region").innerHTML = "Region: " + region;
    document.getElementById("e-conf-type").innerHTML = "Type: " + type;

    $('#confirmEmployee').modal('show');
  }

  //Gets Data and Shows Solution Modal
  function showSOModal() {
    var name = document.getElementById("so-name").value;
    var type = $("#so-type :selected").text(); 

    document.getElementById("so-conf-name").innerHTML = "Name: " + name;
    document.getElementById("so-conf-type").innerHTML = "Type: " + type;

    $('#confirmSolution').modal('show');
  }

  //Gets Data and Shows Scanner Modal
  function showSCModal() {
    var name = document.getElementById("sc-name").value;
    var dclass = $("#sc-class :selected").text(); 
    var firm = $("#sc-firm :selected").text(); 

    var flatbed = "";
    var adf = "";
    var sheet_feed = "";

    if ($("input[type='radio'][name='scflatbed']:checked").val() == "true")
      flatbed = "Yes";
    else if ($("input[type='radio'][name='scflatbed']:checked").val() == "false")
      flatbed = "No";
    if ($("input[type='radio'][name='scadf']:checked").val() == "true")
      adf = "Yes";
    else if ($("input[type='radio'][name='scadf']:checked").val() == "false")
      adf = "No";
    if ($("input[type='radio'][name='scsheet_feed']:checked").val() == "true")
      sheet_feed = "Yes";
    else if ($("input[type='radio'][name='scsheet_feed']:checked").val() == "false")
      sheet_feed = "No";

    document.getElementById("sc-conf-name").innerHTML = "Model Name: " + name;
    document.getElementById("sc-conf-class").innerHTML = "Device Class: " + dclass;
    document.getElementById("sc-conf-firm").innerHTML = "Firmware Type: " + firm;
    document.getElementById("sc-conf-flatbed").innerHTML = "Flatbed: " + flatbed;
    document.getElementById("sc-conf-adf").innerHTML = "ADF: " + adf;
    document.getElementById("sc-conf-sheet_feed").innerHTML = "Sheet Feed: " + sheet_feed;

    $('#confirmScanner').modal('show');
  }

  //Gets Data and Shows Data Options Modal
  function showDOModal() {
    var name = document.getElementById("do-name").value;
    var type = $("#do-type :selected").text();

    document.getElementById("do-conf-name").innerHTML = "Name: " + name;
    document.getElementById("do-conf-type").innerHTML = "Type: " + type;

    $('#confirmData').modal('show');
  }

  //Gets Data and Shows Customer-Printer Modal
  function showCPModal() {
    var cName = $("#cp-cname :selected").text();
    var pName = $("#cp-pname :selected").text();
    var qty = document.getElementById("cp-qty").value;
    var fs4 = "";
    var notes = document.getElementById("cp-notes").value;

    if ($("input[type='radio'][name='cpfs4']:checked").val() == "true")
      fs4 = "FS4";
    else if ($("input[type='radio'][name='cpfs4']:checked").val() == "false")
      fs4 = "FS3";

    document.getElementById("cp-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("cp-conf-pname").innerHTML = "Printer Name: " + pName;
    document.getElementById("cp-conf-qty").innerHTML = "Quantity in Fleet: " + qty;
    document.getElementById("cp-conf-fs4").innerHTML = "FS3/FS4: " + fs4;
    document.getElementById("cp-conf-notes").innerHTML = "Notes: " + notes;

    $('#confirmCP').modal('show');
  }

  //Gets Data and Shows Customer-Scanner Modal
  function showCSModal() {
    var cName = $("#cs-cname :selected").text();
    var sName = $("#cs-sname :selected").text();
    var qty = document.getElementById("cs-qty").value;
    var fs4 = "";
    var notes = document.getElementById("cs-notes").value;

    if ($("input[type='radio'][name='csfs4']:checked").val() == "true")
      fs4 = "FS4";
    else if ($("input[type='radio'][name='csfs4']:checked").val() == "false")
      fs4 = "FS3";

    document.getElementById("cs-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("cs-conf-sname").innerHTML = "Printer Name: " + sName;
    document.getElementById("cs-conf-qty").innerHTML = "Quantity in Fleet: " + qty;
    document.getElementById("cs-conf-fs4").innerHTML = "FS3/FS4: " + fs4;
    document.getElementById("cs-conf-notes").innerHTML = "Notes: " + notes;

    $('#confirmCS').modal('show');
  }

  //Gets Data and Shows Customer-Solution Modal
  function showCSOModal() {
    var cName = $("#cso-cname :selected").text();
    var sName = $("#cso-sname :selected").text();
    var version = document.getElementById("cso-version").value;
    var qty = document.getElementById("cso-qty").value;
    var notes = document.getElementById("cso-notes").value;


    document.getElementById("cso-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("cso-conf-sname").innerHTML = "Printer Name: " + sName;
    document.getElementById("cso-conf-version").innerHTML = "Version: " + version;
    document.getElementById("cso-conf-qty").innerHTML = "Quantity of Licenses: " + qty;
    document.getElementById("cso-conf-notes").innerHTML = "Notes: " + notes;

    $('#confirmCSO').modal('show');
  }

  //Gets Data and Shows Customer-Employee Modal
  function showCEModal() {
    var cName = $("#ce-cname :selected").text();
    var eName = $("#ce-ename :selected").text();

    document.getElementById("ce-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("ce-conf-ename").innerHTML = "Employee Name: " + eName;

    $('#confirmCE').modal('show');
  }

  //Gets Data and Shows Customer-Contact Modal
  function showCCModal() {
    var cName = $("#cc-cname :selected").text();
    var coName = document.getElementById("cc-coname").value;
    var title = document.getElementById("cc-title").value;
    var location = $("#cc-location :selected").text();
    var email = document.getElementById("cc-email").value;
    var business_phone = document.getElementById("cc-business_phone").value;
    var mobile_phone = document.getElementById("cc-mobile_phone").value;
    var notes = document.getElementById("cc-notes").value;
    var main = "";

    if ($("input[type='radio'][name='ccmain']:checked").val() == "true")
      main = "Yes";
    else if ($("input[type='radio'][name='ccmain']:checked").val() == "false")
      main = "No";

    document.getElementById("cc-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("cc-conf-coname").innerHTML = "Contact Name: " + coName;
    document.getElementById("cc-conf-title").innerHTML = "Title: " + title;
    document.getElementById("cc-conf-location").innerHTML = "Location: " + location;
    document.getElementById("cc-conf-email").innerHTML = "Email: " + email;
    document.getElementById("cc-conf-business_phone").innerHTML = "Business Phone: " + business_phone;
    document.getElementById("cc-conf-mobile_phone").innerHTML = "Mobile Phone: " + mobile_phone;
    document.getElementById("cc-conf-notes").innerHTML = "Notes: " + notes;
    document.getElementById("cc-conf-main_contact").innerHTML = "Main Contact: " + main;

    $('#confirmCC').modal('show');
  }

  //Gets Data and Shows Location Modal
  function showLocationModal() {
    var address = document.getElementById("l-address").value;
    var city = document.getElementById("l-city").value;
    var state = document.getElementById("l-state").value;
    var zip = document.getElementById("l-zip").value;
    var country = document.getElementById("l-country").value;

    document.getElementById("l-conf-address").innerHTML = "Street: " + address;
    document.getElementById("l-conf-city").innerHTML = "City: " + city;
    document.getElementById("l-conf-state").innerHTML = "State: " + state;
    document.getElementById("l-conf-zip").innerHTML = "Zip: " + zip;
    document.getElementById("l-conf-country").innerHTML = "Country: " + country;

    $('#confirmLocation').modal('show');
  }

  //Gets Data and Shows Customer-Location Modal
  function showCLModal() {
    var cName = $("#cl-cname :selected").text();
    var address = $("#cl-address :selected").text();

    document.getElementById("cl-conf-cname").innerHTML = "Customer Name: " + cName;
    document.getElementById("cl-conf-address").innerHTML = "Address: " + address;

    $('#confirmCL').modal('show');   
  }

  //Gets Data and Shows Printer Modal
  function showPModal() {
    var name = document.getElementById("p-name").value;
    var pclass = document.getElementById("p-class").value;
    var firm = document.getElementById("p-firm").value;
    var mfp = "";
    var color = "";
    var duplex = "";
    var supports_sm = "";
    var sm_inst_on_cap = "";
    var sure_start = "";
    var whitelisting = "";
    var run_time_int_det = "";
    var connection_inspector = "";
    var is_a4 = "";


    if ($("input[type='radio'][name='pmfp']:checked").val() == "true")
      mfp = "MFP";
    else if ($("input[type='radio'][name='pmfp']:checked").val() == "false")
      mfp = "SFP";
    if ($("input[type='radio'][name='pcolor']:checked").val() == "true")
      color = "Color";
    else if ($("input[type='radio'][name='pcolor']:checked").val() == "false")
      color = "Mono";
    if ($("input[type='radio'][name='pduplex']:checked").val() == "true")
      duplex = "Duplex";
    else if ($("input[type='radio'][name='pduplex']:checked").val() == "false")
      duplex = "Simplex";
    if ($("input[type='radio'][name='psupports_sm']:checked").val() == "true")
      supports_sm = "Yes";
    else if ($("input[type='radio'][name='psupports_sm']:checked").val() == "false")
      supports_sm = "No";
    if ($("input[type='radio'][name='psm_inst_on_cap']:checked").val() == "true")
      sm_inst_on_cap = "Yes";
    else if ($("input[type='radio'][name='psm_inst_on_cap']:checked").val() == "false")
      sm_inst_on_cap = "No";
    if ($("input[type='radio'][name='psure_start']:checked").val() == "true")
      sure_start = "Yes";
    else if ($("input[type='radio'][name='psure_start']:checked").val() == "false")
      sure_start = "No";
    if ($("input[type='radio'][name='pwhitelisting']:checked").val() == "true")
      whitelisting = "Yes";
    else if ($("input[type='radio'][name='pwhitelisting']:checked").val() == "false")
      whitelisting = "No";
    if ($("input[type='radio'][name='prun_time_int_det']:checked").val() == "true")
      run_time_int_det = "Yes";
    else if ($("input[type='radio'][name='prun_time_int_det']:checked").val() == "false")
      run_time_int_det = "No";
    if ($("input[type='radio'][name='pconnection_inspector']:checked").val() == "true")
      connection_inspector = "Yes";
    else if ($("input[type='radio'][name='pconnection_inspector']:checked").val() == "false")
      connection_inspector = "No";
    if ($("input[type='radio'][name='pis_a4']:checked").val() == "true")
      is_a4 = "A4";
    else if ($("input[type='radio'][name='pis_a4']:checked").val() == "false")
      is_a4 = "A3";

    document.getElementById("p-conf-name").innerHTML = "Name: " + name;
    document.getElementById("p-conf-class").innerHTML = "Device Class: " + pclass;
    document.getElementById("p-conf-firm").innerHTML = "Firmware Type: " + firm;
    document.getElementById("p-conf-mfp").innerHTML = "MFP/SFP: " + mfp;
    document.getElementById("p-conf-color").innerHTML = "Color/Mono: " + color;
    document.getElementById("p-conf-duplex").innerHTML = "Duplex/Simplex: " + duplex;
    document.getElementById("p-conf-supports_sm").innerHTML = "Supports Security Manager: " + supports_sm;
    document.getElementById("p-conf-sm_inst_on_cap").innerHTML = "SM Instant On Capability: " + sm_inst_on_cap;
    document.getElementById("p-conf-sure_start").innerHTML = "Sure Start: " + sure_start;
    document.getElementById("p-conf-whitelisting").innerHTML = "Whitelisting: " + whitelisting;
    document.getElementById("p-conf-run_time_int_det").innerHTML = "Run Time Intrusion Detection: " + run_time_int_det;
    document.getElementById("p-conf-connection_inspector").innerHTML = "Connection Inspector: " + connection_inspector;
    document.getElementById("p-conf-is_a4").innerHTML = "A3/A4: " + is_a4;

    $('#confirmPrinter').modal('show');
  }

</script>


<body>

<div class="row">

  <!--  Customer Card  -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Customers</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="c-name" name="cname" placeholder="Name" class="card-input" <?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['cname'] . '"'; } ?> ><br/>
          <input type="text"  id="c-phone"name="cphone" placeholder="Phone" class="card-input" <?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['cphone'] . '"'; } ?>><br/>
          <select id="c-region" name="cregion" class="card-input">
            <?php
            foreach($regions as $row)
            {
              //Keep selected element on insert error instead of resetting the form
              $selected = '';
              if ($_POST['cregion'] == $row['region'] && $_SESSION['dbFail']) {
                $selected = ' selected ';
              }
              echo '<option value="' . $row['region'] . '"' . $selected . '>' . $row['region'] . '</option>';
            }
            ?>
          </select>
          <select id="c-type" name="ctype" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($custType->fetchAll() as $row)
            {
              $selected = '';
              if ($_POST['ctype'] == $row['name'] && $_SESSION['dbFail']) {
                $selected = ' selected ';
              }
              echo '<option value="' . $row['name'] . '"' . $selected . '>' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <textarea id ="c-notes" name="cnotes" placeholder="Notes" class="card-input"><?php if($_SESSION['dbFail']) { echo $_POST['cnotes']; } ?></textarea><br/>
          <input type="submit" id="submitCustomer" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

  <!-- Employee Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Employees</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="e-name" name="ename" placeholder="Name" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['ename'] . '"'; } ?>><br/>
          <input type="text" id="e-email" name="eemail" placeholder="Email" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['eemail'] . '"'; } ?>><br/>
          <input type="password" id="e-password" name="epassword" placeholder="Password" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['epassword'] . '"'; } ?>><br/>
          <select id="e-region" name="eregion" class="card-input">
            <?php
            foreach($regions as $row)
            {
              //Keep selected element on insert error instead of resetting the form
              $selected = '';
              if ($_POST['eregion'] == $row['region'] && $_SESSION['dbFail']) {
                $selected = ' selected ';
              }
              echo '<option value="' . $row['region'] . '"' . $selected . '>' . $row['region'] . '</option>';
            }
            ?>
          </select>
          <select name="etype" id="e-type" class="card-input">
<!--            <option disabled selected hidden>Employee Type</option> -->
            <?php
            //Get all options from employeeType enum and place in select options
            foreach($empType as $row)
            {
                echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <input type="submit" id="submitEmployee" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showEModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>


 <!-- KEEP DATA when a fail on insert occurs!!!!!!!! -->

  <!-- Printers Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Printers</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="p-name" name="pname" placeholder="Model Name" class="card-input"><br/>
          <select id="p-class" name="pclass" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($classes as $row)
            {
                echo '<option value="' . $row['class'] . '">' . $row['class'] . '</option>';
            }
           ?>
          </select><br/>
          <select id="p-firm" name="pfirm" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($firmware as $row)
            {
                echo '<option value="' . $row['firm'] . '">' . $row['firm'] . '</option>';
            }
            ?>
          </select><br/>

          <div class="left">
          <h6>MFP/SFP: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pmfp" value="true"> MFP</label>
          <label class="radio-inline"><input type="radio" name="pmfp" value="false"> SFP</label><br/>
          <h6>Color/Mono: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pcolor" value="true"> Color</label>
          <label class="radio-inline"><input type="radio" name="pcolor" value="false"> Mono</label><br/>           
          <h6>Duplex/Simplex: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pduplex" value="true"> Duplex</label>
          <label class="radio-inline"><input type="radio" name="pduplex" value="false"> Simplex</label><br/>
          <h6>Supports Security Manager: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psupports_sm" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psupports_sm" value="false"> No</label><br/>
          <h6>SM Instant On Capability &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psm_inst_on_cap" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psm_inst_on_cap" value="false"> No</label><br/>
          <h6>Sure Start &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="psure_start" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="psure_start" value="false"> No</label><br/>
          <h6>Whitelisting &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pwhitelisting" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="pwhitelisting" value="false"> No</label><br/>
          <h6>Run Time Intrusion Detection &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="prun_time_int_det" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="prun_time_int_det" value="false"> No</label><br/>
          <h6>Connection Inspector &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pconnection_inspector" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="pconnection_inspector" value="false"> No</label><br/>
          <h6>A3/A4 &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="pis_a4" value="false"> A3</label>
          <label class="radio-inline"><input type="radio" name="pis_a4" value="true"> A4</label><br/>
          </div>
          <input type="submit" id="submitPrinter" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showPModal()">Insert</button>
        </form>
        </p>
     </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Scanners Card -->
  <div class="col-md-4">
    <div class="card">
      <div class="card-header bg-dark">
        <h4>Scanners</h4>
      </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="sc-name" name="scname" placeholder="Model Name" class="card-input"><br/>
          <select id="sc-class" name="scclass" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($classes as $row)
            {
                echo '<option value="' . $row['class'] . '">' . $row['class'] . '</option>';
            }
           ?>
          </select><br/>
          <select id="sc-firm" name="scfirm" class="card-input">
            <?php
            //Get all options from customerType enum and place in select options
            foreach($firmware as $row)
            {
                echo '<option value="' . $row['firm'] . '">' . $row['firm'] . '</option>';
            }
            ?>
          </select><br/>

          <div class="left">
          <h6>Flatbed: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scflatbed" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scflatbed" value="false"> No</label><br/>
          <h6>ADF: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scadf" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scadf" value="false"> No</label><br/>           
          <h6>Sheet Feed: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="scsheet_feed" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="scsheet_feed" value="false"> No</label><br/>
          </div>
          <input type="submit" id="submitScanner" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showSCModal()">Insert</button>
        </form>
        </p>
     </div>
    </div>
  </div>

    <!-- Solutions Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Solutions</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="so-name" name="soname" placeholder="Name" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['soname'] . '"'; } ?>><br/>
          <select name="sotype" id="so-type" class="card-input">
            <?php
            //Get all options from employeeType enum and place in select options
            foreach($solutionType->fetchAll() as $row)
            {
                echo '<option value="' . $row['type'] . '">' . $row['type'] . '</option>';
            }
            ?>
          </select><br/>
          <input type="submit" id="submitSolution" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showSOModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

    <!-- Data Options Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Data Options</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="do-name" name="doname" placeholder="Name" class="card-input"<?php if($_SESSION['dbFail']) { echo 'value="' . $_POST['doname'] . '"'; } ?>><br/>
          <select name="dotype" id="do-type" class="card-input">
            <option value="customerType">Customer Types</option>
            <option value="employeeType">Employee Types</option>
            <option value="regions">Regions</option>
            <option value="deviceClass">Device Classes</option>
            <option value="firmwareType">Firmware Types</option>
            <option value="solutionType">Solution Types</option>
          </select><br/>
          <input type="submit" id="submitData" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showDOModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

</div>

<div class="row">

    <!-- Customer-Printer Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Printer</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="cpcname" id="cp-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <select name="cppname" id="cp-pname" class="card-input">
            <?php
              foreach($printers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
              }
            ?>
          </select>
          <input type="number" id="cp-qty" name="cpqty" placeholder="Quantity in Fleet" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['cpqty'] . '"'; } ?>><br/>
          <div class="left">
          <h6>FS3/FS4: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="cpfs4" value="false"> FS3</label>
          <label class="radio-inline"><input type="radio" name="cpfs4" value="true"> FS4</label><br/>
          </div>
          <textarea id ="cp-notes" name="cpnotes" placeholder="Notes" class="card-input"><?php if($_SESSION['dbFail']) { echo $_POST['cpnotes']; } ?></textarea><br/>
          <input type="submit" id="submitCP" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCPModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>


    <!-- Customer-Scanner Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Scanner</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="cscname" id="cs-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <select name="cssname" id="cs-sname" class="card-input">
            <?php
              foreach($scanners as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
              }
            ?>
          </select>
          <input type="number" id="cs-qty" name="csqty" placeholder="Quantity in Fleet" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['csqty'] . '"'; } ?>><br/>
          <div class="left">
          <h6>FS3/FS4: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="csfs4" value="false"> FS3</label>
          <label class="radio-inline"><input type="radio" name="csfs4" value="true"> FS4</label><br/>
          </div>
          <textarea id ="cs-notes" name="csnotes" placeholder="Notes" class="card-input"><?php if($_SESSION['dbFail']) { echo $_POST['csnotes']; } ?></textarea><br/>
          <input type="submit" id="submitCS" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCSModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

    <!-- Customer-Solution Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Solution</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="csocname" id="cso-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <select name="csosname" id="cso-sname" class="card-input">
            <?php
              foreach($solutions as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
              }
            ?>
          </select>
          <input type="text" id="cso-version" name="csoversion" placeholder="Version" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['csoversion'] . '"'; } ?>><br/>
          <input type="number" id="cso-qty" name="csoqty" placeholder="Quantity of Licenses" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['csoqty'] . '"'; } ?>><br/>
          <textarea id ="cso-notes" name="csonotes" placeholder="Notes" class="card-input"><?php if($_SESSION['dbFail']) { echo $_POST['csonotes']; } ?></textarea><br/>
          <input type="submit" id="submitCSO" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCSOModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

</div>

<div class="row">


    <!-- Customer-Employee Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Employee</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="cecname" id="ce-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <select name="ceename" id="ce-ename" class="card-input">
            <?php
              foreach($employees as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
              }
            ?>
          </select>
          <input type="submit" id="submitCE" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCEModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>


    <!-- Customer-Contact Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Contact</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="cccname" id="cc-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <input type="text" id="cc-coname" name="ccconame" placeholder="Name" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['ccconame'] . '"'; } ?>><br/>
          <input type="text" id="cc-title" name="cctitle" placeholder="Title" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['cctitle'] . '"'; } ?>><br/>
          <input type="text" id="cc-email" name="ccemail" placeholder="Email" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['ccemail'] . '"'; } ?>><br/>
          <input type="text" id="cc-business_phone" name="ccbusiness_phone" placeholder="Business Phone" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['ccbusiness_phone'] . '"'; } ?>><br/>
          <input type="text" id="cc-mobile_phone" name="ccmobile_phone" placeholder="Mobile Phone" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['ccmobile_phone'] . '"'; } ?>><br/>
          <select name="cclocation" id="cc-location" class="card-input">
            <?php
            foreach ($locations as $row) {
              echo '<option value="' . $row['id'] . '">' . $row['address'] . ' ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zip'] . ' ' . $row['country'] . '</option>';
            }
            ?>
          </select>
          <div class="left">
          <h6>Main Contact: &nbsp;&nbsp;</h6>
          <label class="radio-inline"><input type="radio" name="ccmain" value="true"> Yes</label>
          <label class="radio-inline"><input type="radio" name="ccmain" value="false"> No</label><br/>
          </div>
          <textarea id ="cc-notes" name="ccnotes" placeholder="Notes" class="card-input"><?php if($_SESSION['dbFail']) { echo $_POST['ccnotes']; } ?></textarea><br/>
          <input type="submit" id="submitCC" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCCModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>


    <!-- Location Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Location</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <input type="text" id="l-address" name="laddress" placeholder="Street" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['laddress'] . '"'; } ?>><br/>
          <input type="text" id="l-city" name="lcity" placeholder="City" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['laddress'] . '"'; } ?>><br/>
          <input type="text" id="l-state" name="lstate" placeholder="State" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['laddress'] . '"'; } ?>><br/>
          <input type="text" id="l-zip" name="lzip" placeholder="Zip" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['laddress'] . '"'; } ?>><br/>
          <input type="text" id="l-country" name="lcountry" placeholder="Country" class="card-input" <?php if ($_SESSION['dbFail']) { echo 'value="' . $_POST['laddress'] . '"'; } ?>><br/>
          <input type="submit" id="submitLocation" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showLocationModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>

</div>

<div class="row">

    <!-- Customer-Location Card -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-dark">
          <h4>Customer-Location</h4>
        </div>
      <div class="card-block">
        <p class="card-text marg">
        <form action="#" method="POST" class="card-c">
          <select name="clcname" id="cl-cname" class="card-input">
            <?php
            foreach($customers as $row) {
              echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
            }
            ?>
          </select><br/>
          <select name="claddress" id="cl-address" class="card-input">
            <?php
            foreach ($locations as $row) {
              echo '<option value="' . $row['id'] . '">' . $row['address'] . ' ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zip'] . ' ' . $row['country'] . '</option>';
            }
            ?>
          </select>
          <input type="submit" id="submitCL" hidden>
          <button type="button" class="btn btn-primary card-btn" onclick="showCLModal()">Insert</button>
        </form>
        </p>
      </div>
    </div>
  </div>





</div>










  <!-- Success Modal -->
  <div class="modal fade" id="success" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Success!</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>The row was successfully inserted.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Error Modal -->
  <div class="modal fade" id="error" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error!</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>There was an error inserting the row.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Customer Confirm Modal -->
  <div class="modal fade" id="confirmCustomer" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="c-conf-name"></div>
            <div id="c-conf-phone"></div>
            <div id="c-conf-region"></div>
            <div id="c-conf-type"></div>
            <div id="c-conf-notes"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCustomer" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

  <!-- Employee Confirm Modal -->
  <div class="modal fade" id="confirmEmployee" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="e-conf-name"></div>
            <div id="e-conf-email"></div>
            <div id="e-conf-region"></div>
            <div id="e-conf-type"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitEmployee" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>
</div>

  <!-- Printer Confirm Modal -->
  <div class="modal fade" id="confirmPrinter" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="p-conf-name"></div>
            <div id="p-conf-class"></div>
            <div id="p-conf-firm"></div>
            <div id="p-conf-mfp"></div>
            <div id="p-conf-color"></div>
            <div id="p-conf-duplex"></div>
            <div id="p-conf-supports_sm"></div>
            <div id="p-conf-sm_inst_on_cap"></div>
            <div id="p-conf-sure_start"></div>
            <div id="p-conf-whitelisting"></div>
            <div id="p-conf-run_time_int_det"></div>
            <div id="p-conf-connection_inspector"></div>
            <div id="p-conf-is_a4"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitPrinter" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Solution Confirm Modal -->
  <div class="modal fade" id="confirmSolution" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="so-conf-name"></div>
            <div id="so-conf-type"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitSolution" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Scanner Confirm Modal -->
  <div class="modal fade" id="confirmScanner" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="sc-conf-name"></div>
            <div id="sc-conf-class"></div>
            <div id="sc-conf-firm"></div>
            <div id="sc-conf-flatbed"></div>
            <div id="sc-conf-adf"></div>
            <div id="sc-conf-sheet_feed"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitScanner" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Data Options Confirm Modal -->
  <div class="modal fade" id="confirmData" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="do-conf-name"></div>
            <div id="do-conf-type"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitData" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Customer Printer Confirm Modal -->
  <div class="modal fade" id="confirmCP" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="cp-conf-cname"></div>
            <div id="cp-conf-pname"></div>
            <div id="cp-conf-qty"></div>
            <div id="cp-conf-fs4"></div>
            <div id="cp-conf-notes"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCP" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Customer Scanner Confirm Modal -->
  <div class="modal fade" id="confirmCS" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="cs-conf-cname"></div>
            <div id="cs-conf-sname"></div>
            <div id="cs-conf-qty"></div>
            <div id="cs-conf-fs4"></div>
            <div id="cs-conf-notes"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCS" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Customer Solution Confirm Modal -->
  <div class="modal fade" id="confirmCSO" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="cso-conf-cname"></div>
            <div id="cso-conf-sname"></div>
            <div id="cso-conf-version"></div>
            <div id="cso-conf-qty"></div>
            <div id="cso-conf-notes"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCSO" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Customer Solution Confirm Modal -->
  <div class="modal fade" id="confirmCE" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="ce-conf-cname"></div>
            <div id="ce-conf-ename"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCE" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Customer Contact Confirm Modal -->
  <div class="modal fade" id="confirmCC" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="cc-conf-cname"></div>
            <div id="cc-conf-coname"></div>
            <div id="cc-conf-title"></div>
            <div id="cc-conf-location"></div>
            <div id="cc-conf-email"></div>
            <div id="cc-conf-business_phone"></div>
            <div id="cc-conf-mobile_phone"></div>
            <div id="cc-conf-main_contact"></div>
            <div id="cc-conf-notes"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCC" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <!-- Location Confirm Modal -->
  <div class="modal fade" id="confirmLocation" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="l-conf-address"></div>
            <div id="l-conf-city"></div>
            <div id="l-conf-state"></div>
            <div id="l-conf-zip"></div>
            <div id="l-conf-country"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitLocation" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>


  <!-- Customer-Location Confirm Modal -->
  <div class="modal fade" id="confirmCL" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to insert this row?</h6>
          <p>
            <div id="cl-conf-cname"></div>
            <div id="cl-conf-address"></div>
          </p>
        </div>
        <div class="modal-footer">
          <label for="submitCL" class="btn btn-primary" tabindex="0">Yes</label>
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>



</body>
</html>