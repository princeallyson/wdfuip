<?php
require("../config/db_connection.php");
session_start();


if(isset($_POST['designation']) && isset($_POST['department'])){
    $designation = $_POST['designation'];
    $department = $_POST['department'];

    $data = '';

    $result = mysqli_query($conn, "SELECT user_id, name, designation, department FROM users WHERE designation = '".$designation."' AND department = '".$department."' ORDER BY name ASC");
    while($row = mysqli_fetch_assoc($result)){
        $id = $row['user_id'];
        $name = $row['name'];
        $data .= '<option value="'.$name.'" data-signatory-id="'.$id.'">'.$name.'</option>';
    }

    echo $data;
}

if(isset($_POST['document_id'])){
    $document_id = $_POST['document_id'];
    $data = '<input type="hidden" name="document_id" id="id" value="'.$document_id.'">';

    $result = mysqli_query($conn, "SELECT document_id, document_type FROM documents WHERE document_id = '".$document_id."'");
    while($row = mysqli_fetch_assoc($result)){
        $document_type = $row['document_type'];
        if($document_type == "Thesis/Dissertation Concept Paper Adviser Endorsement Form" || $document_type == "Thesis/Dissertation Adviser Appointment and Acknowledgement Form" || $document_type == "Thesis/Dissertation Confidentiality Non-Disclosure Agreement" || $document_type == "Thesis/Dissertation Adviser Appointment and Acknowledgement Form" || $document_type == "Thesis/Dissertation Pre-Final Endorsement Form"){
            for($i = 0; $i < 2; $i++){
                $data .= '<p>Signatory '.($i+1).'</p>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Designation</label>
                      <select class="form-select designation_signatory" name="designation[]" id="designation_signatory">
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Department</label>
                      <select class="form-select department_signatory" name="department[]" id="department_signatory">
                      </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Signatory</label>
                      <select class="form-select signatory" name="signatory[]" id="signatory">
                      </select>
                    </div>
                </div>';
            }
        }
        elseif($document_type == "Thesis/Dissertation Advising Contract" || $document_type == "Ethics Review Application Form"){
            for($i = 0; $i < 3; $i++){
                $data .= '<p>Signatory '.($i+1).'</p>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Designation</label>
                      <select class="form-select designation_signatory" name="designation[]" id="designation_signatory">
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Department</label>
                      <select class="form-select department_signatory" name="department[]" id="department_signatory">
                      </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Signatory</label>
                      <select class="form-select signatory" name="signatory[]" id="signatory">
                      </select>
                    </div>
                </div>';
            }
        }
        elseif($document_type == "Thesis/Dissertation Consultation/Monitoring Form" || $document_type == "Thesis/Dissertation Proposal Defense Evaluation Sheet" || $document_type == "Thesis/Dissertation Pre-Final Evaluation Sheet" || $document_type == "Thesis/Dissertation Final Defense Evaluation Sheet"){
            $data .= '<div class="row">
                <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Designation</label>
                  <select class="form-select designation_signatory" name="designation[]" id="designation_signatory">
                  </select>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Department</label>
                  <select class="form-select department_signatory" name="department[]" id="department_signatory">
                  </select>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
                  <label for="exampleFormControlInput1" class="form-label">Signatory</label>
                  <select class="form-select signatory" name="signatory[]" id="signatory">
                  </select>
                </div>
            </div>';
        }
        else {
            for($i = 0; $i < 5; $i++){
                $data .= '<p>Signatory '.($i+1).'</p>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Designation</label>
                      <select class="form-select designation_signatory" name="designation[]" id="designation_signatory">
                      </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Department</label>
                      <select class="form-select department_signatory" name="department[]" id="department_signatory">
                      </select>
                    </div>
                    <div class="col-lg-12 col-md-12 col-xs-12 mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Signatory</label>
                      <select class="form-select signatory" name="signatory[]" id="signatory">
                      </select>
                    </div>
                </div>';
            }
        }
    }
    echo $data;
}

?>
