<?php
require 'header.php';
require 'functions.php';

echo 'Hello World';

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

      if (!$insert->execute())
      {
          echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
          $_SESSION['dbFail'] = true;
      }
      else
      {
          echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
          $_SESSION['dbFail'] = false;
      }

}

echo 'Hello World #2';

  //Employee Insert
  if (isset($_POST['ename']))
  {
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
      $insert->bindValue(':password',emptyToNull($_POST['epassword']),PDO::PARAM_STR);
      $insert->bindValue(':type',emptyToNull($_POST['etype']),PDO::PARAM_STR);
      $insert->bindValue(':region',emptyToNull($_POST['eregion']),PDO::PARAM_STR);
      
      if (!$insert->execute())
      {
          echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
          $_SESSION['dbFail'] = true;
      }
      else
      {
          echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
          $_SESSION['dbFail'] = false;
      }
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

      if (!$insert->execute())
      {
          echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
          $_SESSION['dbFail'] = true;
      }
      else
      {
          echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
          $_SESSION['dbFail'] = false;
      }

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

      if (!$insert->execute())
      {
          echo '<script> $(window).on("load", function(){ $("#error").modal("show"); }); </script>';
          $_SESSION['dbFail'] = true;
      }
      else
      {
          echo '<script> $(window).on("load", function(){ $("#success").modal("show"); }); </script>';
          $_SESSION['dbFail'] = false;
      }
  }


?>

<script>
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
    var type = $("#sc-type :selected").text(); 
    var firm = $("#sc-firm :selected").text(); 

    var flatbed = "";
    var adf = "";
    var sheet_feed = "";

    if ($("input[type='radio'][name='scflatbed']:checked").val() == "true")
      flatbed = "Yes";
    else if ($("input[type='radio'][name='scflatbed']:checked").val() == "false")
      flatbed = "No";
    if ($("input[type='radio'][name='scadf']:checked").val() == "true")
      flatbed = "Yes";
    else if ($("input[type='radio'][name='scadf']:checked").val() == "false")
      flatbed = "No";
    if ($("input[type='radio'][name='scsheet_feed']:checked").val() == "true")
      flatbed = "Yes";
    else if ($("input[type='radio'][name='scsheet_feed']:checked").val() == "false")
      flatbed = "No";

    document.getElementById("sc-conf-name").innerHTML = "Model Name: " + name;
    document.getElementById("sc-conf-class").innerHTML = "Device Class: " + type;
    document.getElementById("sc-conf-firm").innerHTML = "Firmware Type: " + firm;
    document.getElementById("sc-conf-flatbed").innerHTML = "Flatbed: " + flatbed;
    document.getElementById("sc-conf-adf").innerHTML = "ADF: " + adf;
    document.getElementById("sc-conf-sheet_feed").innerHTML = "Sheet Feed: " + sheet_feed;

    $('#confirmScanner').modal('show');
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
</div>
