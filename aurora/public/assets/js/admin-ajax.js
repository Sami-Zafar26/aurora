
$(document).ready(function () {
  

$("#create-package-form").on("submit",function (e) {
    e.preventDefault();
    formdata = $(this).serialize();

    $.ajax({
        url: "/create-package",
        type: "POST",
        data: formdata,
        success: function (data) {
            if (data == 1) {
                $('#create-package-modal').modal('hide')
                $("#create-package-form").trigger("reset");
                $("#toasty-success-message .toasty p").text("Package Created Successfully!");
                $("#toasty-success-message").slideDown();
                $("#toasty-error-message").slideUp();
                setTimeout(() => {
                  $("#toasty-success-message").slideUp();
                  location.reload();
                }, 2000);
              }
              else  {
                $('#create-package-modal').modal('hide')
                $("#create-package-form").trigger("reset");
                $("#toasty-error-message .toasty p").text("Error: Package Not Created!");
                $("#toasty-error-message").slideDown();
                $("#toasty-success-message").slideUp();
                setTimeout(() => {
                  $("#toasty-error-message").slideUp();
                }, 2000);
              }
        }
    });
});

$(document).on("click",".edit-package", function (e) {
  var package_token = $(this).data('package-token');
  $.ajax({
    url: "/edit-package",
    type: "POST",
    data: {token:package_token},
    success: function (data) {
      $('#edit-package-modal').modal('show')
      $("#edit-package-form .modal-body").html(data);
    }
  });
});

$("#edit-package-form").on("submit", function (e) {
  e.preventDefault();
  var formdata=$(this).serialize();
  $.ajax({
    url: "/update-package",
    type: "POST",
    data: formdata,
    success: function (data) {
      if (data == 1) {
        $('#edit-package-modal').modal('hide')
        $("#edit-package-form").trigger("reset");
        $("#toasty-success-message .toasty p").text("Package Updated Successfully!");
        $("#toasty-success-message").slideDown();
        $("#toasty-error-message").slideUp();
        setTimeout(() => {
          $("#toasty-success-message").slideUp();
          location.reload();
        }, 2000);
      }
      else  {
        $('#edit-package-modal').modal('hide')
        $("#edit-package-form").trigger("reset");
        $("#toasty-error-message .toasty p").text("Error: Package Not Updated!");
        $("#toasty-error-message").slideDown();
        $("#toasty-success-message").slideUp();
        setTimeout(() => {
          $("#toasty-error-message").slideUp();
        }, 2000);
      }
    }
  });
});


$(document).on("click",".delete-package",function (e) {
  var package_token = $(this).data('package-token');

   var boolean = confirm("Are you sure you want to delete this package?");
   if (boolean) {
    $.ajax({
      url: "/delete-package",
      type: "POST",
      data: {token: package_token},
      success: function (data) {
        if (data == 1) {
          $("#toasty-success-message .toasty p").text("Package Deleted Successfully!");
          $("#toasty-success-message").slideDown();
          $("#toasty-error-message").slideUp();
          setTimeout(() => {
            $("#toasty-success-message").slideUp();
            location.reload();
          }, 2000);
        }
        else  {
          $("#toasty-error-message .toasty p").text("Error: Package Not Deleted!");
          $("#toasty-error-message").slideDown();
          $("#toasty-success-message").slideUp();
          setTimeout(() => {
            $("#toasty-error-message").slideUp();
          }, 2000);
        }
      }
    });
   }
});


// Users page ajax

$(document).on("click",".bann", function (e) {
   var user_token = $(this).data('user-token');
   var boolean = confirm("Are you sure you want to Bann this User?");
   if (boolean) {
    $.ajax({
      url: "/user-bann",
      type: "POST",
      data: {token: user_token},
      success: function (data) {
        if (data == 1) {
          $("#toasty-success-message .toasty p").text("User Banned Successfully!");
          $("#toasty-success-message").slideDown();
          $("#toasty-error-message").slideUp();
          setTimeout(() => {
            $("#toasty-success-message").slideUp();
            location.reload();
          }, 2000);
        }
        else  {
          $("#toasty-error-message .toasty p").text("Error: User Not Banned!");
          $("#toasty-error-message").slideDown();
          $("#toasty-success-message").slideUp();
          setTimeout(() => {
            $("#toasty-error-message").slideUp();
          }, 2000);
        }
      }
    });
   }
});

$(document).on("click",".unbann", function (e) {
   var user_token = $(this).data('user-token');
   var boolean = confirm("Are you sure you want to UnBann this User?");
   if (boolean) {
    $.ajax({
      url: "/user-unbann",
      type: "POST",
      data: {token: user_token},
      success: function (data) {
        if (data == 1) {
          $("#toasty-success-message .toasty p").text("User UnBanned Successfully!");
          $("#toasty-success-message").slideDown();
          $("#toasty-error-message").slideUp();
          setTimeout(() => {
            $("#toasty-success-message").slideUp();
            location.reload();
          }, 2000);
        }
        else  {
          $("#toasty-error-message .toasty p").text("Error: User Not UnBanned!");
          $("#toasty-error-message").slideDown();
          $("#toasty-success-message").slideUp();
          setTimeout(() => {
            $("#toasty-error-message").slideUp();
          }, 2000);
        }
      }
    });
   }
});


$("#create-integration-service-btn").click(function () {


  output = ``;

  output += `
  <details>
    <summary>Fields Created</summary>
    <p id='fields-info'></p>
  </details>
  <div class='row'>
    <div class='col-md-12'>
      <label>Service Name:</label>
      <input type='text' class='form-control' name='service_name' placeholder='Service Name...'>
    </div>
    <div class='col-md-12'>
      <label>Service Logo:</label>
      <input type='file' class='form-control' name='logo_location' placeholder='Service Logo...'>
    </div>
    <div class='col-md-6 mt-3'>
      <label>Label:</label>
      <input type='text' class='form-control' id='label' name='label' placeholder='Label...'>
    </div>
    <div class='col-md-6 mt-3'>
    <label>Type:</label>
    <input type='text' class='form-control' id='type' name='type' placeholder='Type...'>
    </div>
    <div class='col-md-6'>
      <label>Name:</label>
      <input type='text' class='form-control' id='name' name='name' placeholder='Name...'>
    </div>
    <div class='col-md-6'>
      <label>Placeholder:</label>
      <input type='text' class='form-control' id='placeholder' name='placeholder' placeholder='Placeholder...'>
    </div>
    <div class='d-flex justify-content-end mt-2'>
      <button type='button' class='btn btn-sm btn-info mb-1' id='add-field'>Add Field</button>
    </div>
  </div>
  `;
  $("#integration-service-modal .modal-body").html(output);
  $("#integration-service-modal h1").text("Create Integration Service");
  $("#integration-service-modal .integration-service-save-btn").addClass("btn-primary");
  $("#integration-service-modal").modal("show");
});

let i=0;
let multidimensional = [];
$(document).on("click","#add-field",function () {
  // let label_name = $("#label").attr('name');
  let label_value = $("#label").val();
  // let type_name = $("#type").attr('name');
  let type_value = $("#type").val();
  // let name_name = $("#name").attr('name');
  let name_value = $("#name").val();
  // let placeholder_name = $("#placeholder").attr('name');
  let placeholder_value = $("#placeholder").val();
  multidimensional[i] = {label:label_value, type: type_value, name: name_value, placeholder: placeholder_value};
  i++;
    // let label_name = $("#label").attr('name');
     label_value = $("#label").val("");
    // let type_name = $("#type").attr('name');
     type_value = $("#type").val("");
    // let name_name = $("#name").attr('name');
     name_value = $("#name").val("");
    // let placeholder_name = $("#placeholder").attr('name');
     placeholder_value = $("#placeholder").val("");
    console.log(i);
    console.log(multidimensional);
    let count = multidimensional.length == null ? 0: multidimensional.length; 
    $("#fields-info").text(count);
  });



});