
var url = window.location.pathname;

$("#password-field-icon").click(function () {
  let fieldtype = $("#passwordField").attr('type');
  console.log("jdflkaj");
  if (fieldtype == "password") {
    $(this).children().removeClass("fa-eye-slash");
    $(this).children().addClass("fa-eye");
    $("#passwordField").attr('type','text');
    // $(this).find("i").removeClass("fa-eye-slash");
  } else {
    $(this).children().removeClass("fa-eye");
    $(this).children().addClass("fa-eye-slash");
    $("#passwordField").attr('type','password');
  }
  
});

if (url != "/login" && url != "/register") {

  $(document).ready(function () {

    var maxFields = 5;
    var wrapper = $(".reference");
    var addBtn = $(".additional-attribute-btn");
    var i = 1;

    $(addBtn).click(function (e) {
      e.preventDefault();
      if (i <= maxFields) {
        i++;
        $(wrapper).append('<div class="row g-2"><div class="col-md-5"><input type="text" class="form-control mb-2" name="attribute_name[]" placeholder="Attribute Name"></div><div class="col-md-5"><input type="text" class="form-control mb-2" name="attribute_value[]" placeholder="Attribute Value"></div><div class="col-md-2"><button  class="remove utility-icon mt-1"><svg class="demolish" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg></button></div></div>');
      }
    });
    $(document).on("click", ".remove", function () {
      console.log($(this).parent().parent().remove());
      i--;
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });


    function select_list() {
      $.ajax({
        url: "/select-list",
        type: "POST",
        success: function (data) {
          if (data) {
            $("#select-list").html(data);
            $("#select-list-mandatory").html(data);
          } else {
            alert("falied");
          }
        }
      });
    }

    select_list();

    $(document).on("click", ".info-btn", function () {

      var lead_token = $(this).data('lead');
      $.ajax({
        url: "/lead-info/" + lead_token,
        type: "POST",
        success: function (data) {
          if (data && !data.error) {
            $('#staticBackdrop').modal('show')
            $("#lead-detail").html(data);
          } else if (data && data.error) {
            $("#lead-detail").html(data.error);
          }
        }
      });
    });

    $("#close-modal").click(function () {
      $("#lead-detail").html("");
    });

    // jQuery("#manaul-form").validate({
    //   rules:{
    //     list_name: "required",
    //   },messages:{
    //     list_name: "The list name is required.",
    //   },
    // })
    $("#manaul-form").on("submit", function (e) {
      e.preventDefault();
      if ($(this).valid()) {
        var formdata = $(this).serialize();
        $.ajax({
          url: "custom-list",
          type: "POST",
          data: formdata,
          success: function (data) {
            if (data == 1) {
              $("#manaul-form").trigger("reset");
              $("#toasty-success-message .toasty p").text("List added Successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
              }, 3000);

              select_list();
            }
            else if (data.error) {
              $("#manaul-form").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else {
              $("#manaul-form").trigger("reset");
              $("#toasty-error-message .toasty p").text("Error: List not added!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
          }
        });
      }
    });

    // jQuery("#manaully-user-add").validate({
    //   rules:{
    //     list_token: "required",
    //     email: "required",
    //   },messages:{
    //     list_token: "Please select the list.",
    //     email: "The email is required.",
    //   },
    // })

    $("#manaully-user-add").submit(function (form) {
      i = 1;
      $(".reference .row").remove();

      form.preventDefault();
      if ($(this).valid()) {
        var dataform = $(this).serialize();
        $.ajax({
          url: "custom-add",
          type: "POST",
          data: dataform,
          success: function (data) {
            if (data == 1) {
              $("#custom-add").modal('hide');
              $("#manaully-user-add").trigger("reset");
              $("#toasty-success-message .toasty p").text("Lead added Successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
              }, 3000);
            }
            else if (data == 2) {
              // $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text("Lead already existed in this list failed to save!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else if (data.error) {
              // $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else {
              $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text("Error: Lead not added!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
          }
        });
      }
    });


    // jQuery("#list-lead-manaully-user-add-form").validate({
    //   rules:{
    //     email: "required",
    //   },messages:{
    //     email: "The email is required.",
    //   },
    // })

    $("#list-lead-manaully-user-add-form").on("submit", function (e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      if ($(this).valid()) {
        $.ajax({
          url: "/list-lead-manaully-user-add",
          type: "POST",
          data: formdata,
          success: function (data) {
            if (data == 1) {
              $("#manaully-user-add").trigger("reset");
              $("#custom-add").modal('hide')
              $("#toasty-success-message .toasty p").text("Lead added Successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 3000);
            }
            else if (data == 2) {
              // $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text("Lead already existed in this list failed to save!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else if (data.error) {
              // $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else {
              $("#manaully-user-add").trigger("reset");
              $("#toasty-error-message .toasty p").text("Error: Lead not added!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
          }
        });
      }
    });

    // $.validator.addMethod("csv", function(value, element) {
    // // Get the file extension and convert it to lowercase
    // var extension = value.split('.').pop().toLowerCase();
    // // Check if the extension is "csv"
    // return extension === "csv";
    // }, "Please select a CSV file.");

    // jQuery("#uploadfile").validate({
    //   rules:{
    //     list_name:"required",
    //     // csv_file: {
    //     //   required: true,
    //     //   csv: true // Use the custom "csv" method for CSV file validation
    //     // }
    //   }
    //   ,messages:{
    //     list_name:"The list name is required.",
    //     // csv_file: {
    //     //   required: "Please select a CSV file.",
    //     // }
    //   }
    // });
    $('#uploadfile').submit(function (e) {
      e.preventDefault();
      // var file = $("#formFile")[0];
      var formData = new FormData();
      // if (file.files.length > 0) {
      formData.append("csv_file", $("#formFile")[0].files[0]);
      //   console.log("yes");
      // }else{
      //   console.log("nope");
      // }

      formData.append("list_name", $("#list_name").val());
      formData.append("list_description", $("#list_description").val());
      // var formData = $(this).serialize();
      // if ($(this).valid()) {

      // console.log(formdata);
      $.ajax({
        url: 'csv-file', // Replace with your server-side upload route
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
          if (data == 1) {
            $('#staticBackdrop').modal('hide')
            $("#uploadfile").trigger("reset");
            $("#toasty-success-message .toasty p").text("File uploaded successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 2000);
          }
          else if (data.error) {
            $('#staticBackdrop').modal('hide')
            $("#uploadfile").trigger("reset");
            $("#toasty-error-message .toasty p").text(data.error);
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 2000);
          }
          else {
            $('#staticBackdrop').modal('hide')
            $("#uploadfile").trigger("reset");
            $("#toasty-error-message .toasty p").text("Error: File not Uploaded!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 2000);
          }
        }
      });
      // }
    });


    // $.validator.addMethod("csv", function(value, element) {
    // // Get the file extension and convert it to lowercase
    // var extension = value.split('.').pop().toLowerCase();
    // // Check if the extension is "csv"
    // return extension === "csv";
    // }, "Please select a CSV file.");
    //  jQuery("#reupload-list").validate({
    //   rules:{
    //     list_name: "required",
    //     // csv_file:{
    //     //   required:true,
    //     //   csv:true
    //     // }
    //   },
    //   messages:{
    //     list_name:"The list name is required.",
    //     // csv_file: {
    //     //   required: "Please select a CSV file.",
    //     // }
    //   }
    //  });

    $("#reupload-list").submit(function (e) {
      e.preventDefault();
      if ($(this).valid()) {
        var formData = new FormData();
        formData.append("csv_file", $("#reupload-file")[0].files[0]);
        formData.append("list_name", $("#listname").val());
        formData.append("list_description", $("#listdescription").val());
        formData.append("token", $("#token").val());
        $.ajax({
          url: 'reupload-list', // Replace with your server-side upload route
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (data) {
            if (data == 1) {
              $('#reupload-list-modal').modal('hide')
              $("#reupload-list").trigger("reset");
              $("#toasty-success-message .toasty p").text("File uploaded successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 2000);
            }
            // else if(data.error){
            //   $('#reupload-list-modal').modal('hide')
            //   $("#reupload-list").trigger("reset");
            //   $("#toasty-error-message .toasty p").text(data.error);
            //   $("#toasty-error-message").slideDown();
            //   $("#toasty-success-message").slideUp();
            //   setTimeout(() => {
            //     $("#toasty-error-message").slideUp();
            //   }, 2000);
            // }
            else {
              $('#reupload-list-modal').modal('hide')
              $("#reupload-list").trigger("reset");
              $("#toasty-error-message .toasty p").text("Error: File not Uploaded!");
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


    //  $.validator.addMethod("csv", function(value, element) {
    //   // Get the file extension and convert it to lowercase
    //   var extension = value.split('.').pop().toLowerCase();
    //   // Check if the extension is "csv"
    //   return extension === "csv";
    //   }, "Please select a CSV file.");

    // jQuery("#upload-csv-in-existed-list").validate({
    //   rules:{
    //     // list_token:"required",
    //     // csv_file: {
    //     //   required: true,
    //     //   csv: true // Use the custom "csv" method for CSV file validation
    //     // }
    //   }
    //   ,messages:{
    //     // list_token:"The list name is required.",
    //     // csv_file: {
    //     //   required: "Please select a CSV file.",
    //     // }
    //   }
    // });

    $("#upload-csv-in-existed-list").submit(function (e) {
      e.preventDefault();
      if ($(this).valid()) {
        var formData = new FormData();
        formData.append("file", $("#File")[0].files[0]);
        formData.append("token", $("#tokenoflist").val());

        $.ajax({
          url: "/upload-csv",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (data) {
            // console.log(data);
            if (data == 1) {
              $('#static').modal('hide')
              $("#upload-csv-in-existed-list").trigger("reset");
              $("#toasty-success-message .toasty p").text("File uploaded successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
              }, 3000);
            }
            else if (data.error) {
              $('#static').modal('hide')
              $("#upload-csv-in-existed-list").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else if (data.column_missing) {
              $('#static').modal('hide')
              $("#upload-csv-in-existed-list").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.column_missing);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
            else {
              $('#static').modal('hide')
              $("#upload-csv-in-existed-list").trigger("reset");
              $("#toasty-error-message .toasty p").text("Error: File not Uploaded!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 3000);
            }
          }
        });
      }

    });

    var lead_token = null;
    $(document).on("click", ".lead-delete-btn", function () {
      lead_token = $(this).data('lead-token');
      $("#lead-deletemodal").modal("show")
      $("#lead-token").val(lead_token);

    });
    $("#lead-deletemodal .delete").click(function (e) {
      var leadtoken = $("#lead-token").val();
      e.preventDefault();
      $.ajax({
        url: "/delete-lead/" + leadtoken,
        type: "POST",
        success: function (data) {
          if (data == 1) {
            $("#lead-deletemodal").modal('hide')
            $("#toasty-success-message .toasty p").text("Lead deleted Successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1000);
          } else {
            $("#lead-deletemodal").modal('hide')
            $("#toasty-error-message .toasty p").text("Lead Not deleted!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 1500);
          }
        }
      });
    });



    $(document).on("click", ".edit", function () {
      var lead_token = $(this).data('lead-token');
      $.ajax({
        url: "/edit-lead/" + lead_token,
        type: "POST",
        success: function (data) {
          if (data) {
            $('#editmodal').modal('show')
            // $("#edit-lead").html(data);
            $("#edit-lead").prepend(data);
          } else {
            $("#toasty-error-message .toasty p").text(data.error);
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 1500);
          }
        }
      });
    });

    $("#close-edit-modal").click(function () {
      $("#edit-lead .row").remove();
      $("#edit-lead label").remove();
      i = 1;
    });

    $("#add-lead-close-btn").click(function () {
      $(".reference .row").remove();
      // $("#edit-lead label").remove();
      i = 1;
    });

    $("#update-form").on("submit", function (e) {
      i = 1;
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: "/update-lead",
        type: "POST",
        data: formdata,
        success: function (data) {
          if (data == 1) {
            $('#editmodal').modal('hide')
            $("#update-form").trigger("reset");
            $("#toasty-success-message .toasty p").text("Lead Updated Successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1500);
          }
          else if (data.error) {
            $("#update-form").trigger("reset");
            $('#editmodal').modal('hide')
            $("#toasty-error-message .toasty p").text(data.error);
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
          else {
            $("#update-form").trigger("reset");
            $('#editmodal').modal('hide')
            $("#toasty-error-message .toasty p").text("Lead Not Updated!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
        // }
      });
    });


    var list_token = null;

    $(document).on("click", ".list-delete", function (e) {
      $("#deletemodal").modal("show")
      list_token = $(this).data('list-token');
      // $("#deletemodal .modal-body").append(`<input type='hidden' id='list-token' value='${list_token}'>`);
      $("#list-token").val(list_token);
    });
    $("#deletemodal .delete").click(function (e) {
      e.preventDefault();
      // var listtoken = $("#list-token").val();
      var listtoken = $("#list-token").val();
      $.ajax({
        url: "delete-list/" + listtoken,
        type: "POST",
        success: function (data) {
          if (data == 1) {
            $('#deletemodal').modal('hide');
            $("#toasty-success-message .toasty p").text("List deleted Successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1500);
          } else {
            $('#deletemodal').modal('hide');
            $("#toasty-error-message .toasty p").text("List not deleted Successfully!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
      });
    });



    $(document).on("click", ".list-edit", function (e) {
      var listtoken = $(this).data('list-token');
      $.ajax({
        url: "edit-list/" + listtoken,
        type: "POST",
        success: function (data) {
          if (data) {
            $("#edit-list").html(data);
            $('#editmodal').modal('show')
          } else {
            $("#toasty-error-message .toasty p").text(data.error);
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
      });
    });

    $("#list-update-form").on("submit", function (e) {
      e.preventDefault();
      var formdata = $(this).serialize();
      $.ajax({
        url: "update-list",
        type: "POST",
        data: formdata,
        success: function (data) {
          if (data == 1) {
            $('#editmodal').modal('hide')
            $("#list-update-btn").trigger("reset");
            $("#toasty-success-message .toasty p").text("List Updated Successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1500);
          }
          else {
            $('#editmodal').modal('hide')
            $("#list-update-btn").trigger("reset");
            $("#toasty-error-message .toasty p").text("List Not Updated!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
      });
    });




    // User subscription
    $(document).on("click", ".subscribe", function (e) {
      var token = $(this).data('token');
      if (token != "") {
        $.ajax({
          url: "/subscribe-package",
          type: "POST",
          data: { subscribe_token: token },
          success: function (data) {
            if (data == 1) {
              $('#editmodal').modal('hide')
              $("#list-update-btn").trigger("reset");
              $("#toasty-success-message .toasty p").text("Your package has been subscribed to successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 1500);
            }
            else {
              $('#editmodal').modal('hide')
              $("#list-update-btn").trigger("reset");
              $("#toasty-error-message .toasty p").text("Your package is not subscribed!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
          }
        });
      } else {
        location.reload();
      }
    });


    // jQuery("#create-template-form").validate({
    //   rules:{
    //     campaign_template_name: "required",
    //     campaign_template_subject: "required",
    //     textarea: 'required',
    //   },messages:{
    //     campaign_template_name: "The campaign template name is required.",
    //     campaign_template_subject: "The campaign template subject is required.",
    //     textarea: "The campaign template body is required.",
    //   },
    // })

    $("#create-template-form").on("submit", function (e) {
      e.preventDefault();
      var tinymceContent = tinymce.activeEditor.getContent();
      var template_name = $("#campaign_template_name").val();
      var template_subject = $("#campaign_template_subject").val();

      if ($(this).valid()) {
        $.ajax({
          url: "save-campaign-template",
          type: "POST",
          data: {
            campaign_template_name: template_name,
            campaign_template_subject: template_subject,
            campaign_template_body: tinymceContent,
          },
          success: function (data) {
            if (data == 1) {
              window.location.href = "/campaign-templates";
              $("#create-template-form").trigger("reset");
              $("#toasty-success-message .toasty p").text("Your campaign template has been save successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 1500);
            }
            else if (data.error) {
              $("#create-template-form").trigger("reset");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
            else {
              $("#create-template-form").trigger("reset");
              $("#toasty-error-message .toasty p").text("Your campaign template is not subscribed!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
          }
        });
      }
    });

    var template_token = null;
    $(document).on("click", ".campaign-template-delete", function (e) {
      $("#campaign-deletemodal").modal("show")
      template_token = $(this).data('campaign-template-token');
      $("#campaign-token").val(template_token);
    });
    $("#campaign-deletemodal .delete").click(function (e) {
      var templatetoken = $("#campaign-token").val();
      e.preventDefault();
      $.ajax({
        url: "delete-campaign-template",
        type: "POST",
        data: { token: templatetoken },
        success: function (data) {
          if (data == 1) {
            $("#campaign-deletemodal").modal("hide")
            $("#toasty-success-message .toasty p").text("Your campaign template has been deleted successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1500);
          }
          // else if (data.error) {
          //   $("#campaign-deletemodal").modal("hide")
          //   $("#toasty-error-message .toasty p").text(data.error);
          //   $("#toasty-error-message").slideDown();
          //   $("#toasty-success-message").slideUp();
          //   setTimeout(() => {
          //     $("#toasty-error-message").slideUp();
          //     location.reload();
          //   }, 1500);
          // }
          else {
            $("#campaign-deletemodal").modal("hide")
            $("#toasty-error-message .toasty p").text("Your campaign template is not deleted!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
      });
    });

    $(".cancel-delete-btn").click(function () {
      list_token = null;
      lead_token = null;
      template_token = null;
      // $("#deletemodal .modal-body input").remove();
      // $("#lead-deletemodal .modal-body input").remove();
      // $("#campaign-deletemodal .modal-body input").remove();
    });


    $(document).on("click", ".campaign-template-edit", function (e) {
      var template_token = $(this).data('campaign-template-token');
      // console.log(template_token);
      window.location.href = "/edit-campaign-template/" + template_token;
    });

    // jQuery("#update-template-form").validate({
    //   rules:{
    //     campaign_template_name: "required",
    //     campaign_template_subject: "required",
    //     textarea: 'required',
    //   },messages:{
    //     campaign_template_name: "The campaign template name is required.",
    //     campaign_template_subject: "The campaign template subject is required.",
    //     textarea: "The campaign template body is required.",
    //   },
    // })

    $("#update-template-form").on("submit", function (e) {
      var tinymceContent = tinymce.activeEditor.getContent();
      var template_name = $("#campaign_template_name").val();
      var template_subject = $("#campaign_template_subject").val();
      var template_token = $("#token").val();
      e.preventDefault();
      if ($(this).valid()) {
        $.ajax({
          url: "/update-campaign-template",
          type: "POST",
          data: {
            campaign_template_name: template_name,
            campaign_template_subject: template_subject,
            campaign_template_body: tinymceContent,
            token: template_token
          },
          success: function (data) {
            if (data == 1) {
              window.location.href = "/campaign-templates";
              $("#toasty-success-message .toasty p").text("Your campaign template has been save successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 1500);
            }
            else if (data.error) {
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
            else {
              $("#toasty-error-message .toasty p").text("Your campaign template is not subscribed!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
          }
        });
      }
    });

    $(document).on("click", ".template-view", function (e) {
      var campaign_token = $(this).data('campaign-template-token');
      window.location.href = "/template-view/" + campaign_token;
      // $.ajax({
      //   url: "/template-view/"+token,
      //   type: "POST",
      //   data: {token: campaign_token},
      //   success: function (data) {
      //     if (data) {
      //       $(".template-view-background").html(data);
      //     } else if (data.error) {
      //       $(".template-view-background").html(data.error);
      //     }
      //   }
      // });
    });



    $("#create-integration-credential-btn").on("click", function (e) {
      $.ajax({
        url: "find-integration-service",
        type: "POST",
        success: function (data) {
          let integrtaion_service = data;
          $("#integration-credential-modal").modal("show")
          $("#integration-credential-modal h1").text("Create Integration Credential");
          $("#integration-credential-modal form .modal-body").html(`
          <div class="service-box">
          <div class="integration-service-logo-cover integration-services" data-service-token="${data[0]['token']}">
          <img src="../`+ `${data[0]['logo_location']}" alt="">                            
          <h6>${data[0]['service_name']}</h6>
        </div>
        </div>

        <input type='hidden' id='token' name='token' value='${integrtaion_service[0]['token']}'>
        <div id="fields-wrapper" class="mt-3">
                            
        </div>

          `);
          
          // <form id='create-integration-credenstial-form'>
          console.log(data);
          console.log(data[0]['token']);
          console.log(integrtaion_service[0]['token']);

        }
      });
    });

    $(document).on("click", ".integration-services", function (e) {
      var service_token = $(this).data('service-token');
      // $("img").removeClass('active'); 
      $(this).addClass('active');
      console.log(service_token);
      $.ajax({
        url: "smpt-service",
        type: "POST",
        data: { token: service_token },
        success: function (data) {

          let output = `
          <div class='row'>`;
          for (let key in data['json_fields']) {
            output += `<div class='col-md-6'><label>${data['json_fields'][key]['label']}</label><input type='${data['json_fields'][key]['type']}'  class='form-control' name='${data['json_fields'][key]['name']}' placeholder='${data['json_fields'][key]['placeholder']}'></div>`;
            // output = key +" "+" "+ data['json_fields'][key]['label'];
            // console.log(output);
          }
          output += `</div>`;

          // console.log(data['json_fields'][0]['label']);
          console.log(output);
          $("#integration-credential-modal form").addClass('create-integration-credential-form');
          $("#integration-credential-modal .modal-footer button:last").attr('id', 'save-integration-credential-btn');
          $("#integration-credential-modal .modal-footer button:last").addClass('btn-primary');
          $("#save-integration-credential-btn").text("Save");

          $("#fields-wrapper").html(output);
          // $("#integration-credential-modal #fields-wrapper").before("<form id='create-integration-credential-form'>");
          // $("#integration-credential-modal .modal-footer").after("</form>");
        }
      });
    });

    //  $(".create-integration-credential-form").validate({
    //   rules: {
    //     MAIL_INTEGRATION_NAME: {
    //         required: true
    //     },
    //     MAIL_HOST: {
    //         required: true
    //     },
    //     MAIL_PORT: {
    //         required: true,
    //         number: true
    //     },
    //     MAIL_USERNAME: {
    //         required: true
    //     },
    //     MAIL_PASSWORD: {
    //         required: true
    //     },
    //     MAIL_FROM: {
    //         required: true,
    //         email: true
    //     }
    // },
    // messages: {
    //     MAIL_INTEGRATION_NAME: "The mail integration name is required.",
    //     MAIL_HOST: "The mail host is required.",
    //     MAIL_PORT: {
    //         required: "The mail port is required.",
    //         number: "The mail port must be a number."
    //     },
    //     MAIL_USERNAME: "The mail username is required.",
    //     MAIL_PASSWORD: "The mail password is required.",
    //     MAIL_FROM: {
    //         required: "The email address is required.",
    //         email: "Invalid email address."
    //     }
    // },
    //   submitHandler: function (form) {
    //     // event.preventDefault();
    //     // $("#create-integration-credential-form").preventDefault();
    //       //     let formData = {}; // Initialize an empty object to store form data

    //       // // Iterate through form elements
    //       // $("#integration-credential-modal").find('input').each(function() {
    //       //     let inputName = $(this).attr('name');
    //       //     let inputValue = $(this).val();
    //       //     formData[inputName] = inputValue; // Add data to the object
    //       // });
    //       $("#save-integration-credential-btn").attr('disabled', 'disabled');
    //       $("#save-integration-credential-btn").text("Sending...");   

    //       console.log($(".create-integration-credential-form").serialize());
    //     $.ajax({
    //           url: "create-integration-credential",
    //           data: $(".create-integration-credential-form").serialize(),
    //           type: "post",
    //           dataType: "json",
    //           success: function (data) {
    //             // console.log(data);
    //             if (data == 1) {
    //               $("#save-integration-credential-btn").removeAttr("disabled");
    //               $("#save-integration-credential-btn").text("Save");
    //               $("#integration-credential-modal").modal("hide")
    //               $("#toasty-success-message .toasty p").text("Your Integration Credential has been saved successfully!");
    //               $("#toasty-success-message").slideDown();
    //               $("#toasty-error-message").slideUp();
    //               setTimeout(() => {
    //                 $("#toasty-success-message").slideUp();
    //                 location.reload();
    //               }, 1500);
    //             } 
    //             else if (data.error) {
    //               $("#save-integration-credential-btn").removeAttr("disabled");
    //               $("#save-integration-credential-btn").text("Save");
    //               $("#toasty-error-message .toasty p").text(data.error);
    //               $("#toasty-error-message").slideDown();
    //               $("#toasty-success-message").slideUp();
    //               setTimeout(() => {
    //                 $("#toasty-error-message").slideUp();
    //               }, 1500);
    //             }
    //             else if (data.missing_field) {
    //               $("#save-integration-credential-btn").removeAttr("disabled");
    //               $("#save-integration-credential-btn").text("Save");
    //               $("#toasty-error-message .toasty p").text(data.missing_field);
    //               $("#toasty-error-message").slideDown();
    //               $("#toasty-success-message").slideUp();
    //               setTimeout(() => {
    //                 $("#toasty-error-message").slideUp();

    //               }, 1500);
    //             }
    //             else {
    //               $("#save-integration-credential-btn").removeAttr("disabled");
    //               $("#save-integration-credential-btn").text("Save");
    //               $("#toasty-error-message .toasty p").text("Your Integration Credential is not saved!");
    //               $("#toasty-error-message").slideDown();
    //               $("#toasty-success-message").slideUp();
    //               setTimeout(() => {
    //                 $("#toasty-error-message").slideUp();

    //               }, 1500);
    //             }
    //           }
    //         });
    //     return false;
    //   }
    // });

    //   $(".create-integration-credential-form").validate({
    //     rules: {
    //       MAIL_INTEGRATION_NAME: {
    //           required: true
    //       },
    //       MAIL_HOST: {
    //           required: true
    //       },
    //       MAIL_PORT: {
    //           required: true,
    //           number: true
    //       },
    //       MAIL_USERNAME: {
    //           required: true
    //       },
    //       MAIL_PASSWORD: {
    //           required: true
    //       },
    //       MAIL_FROM: {
    //           required: true,
    //           email: true
    //       }
    //   },
    //   messages: {
    //       MAIL_INTEGRATION_NAME: "The mail integration name is required.",
    //       MAIL_HOST: "The mail host is required.",
    //       MAIL_PORT: {
    //           required: "The mail port is required.",
    //           number: "The mail port must be a number."
    //       },
    //       MAIL_USERNAME: "The mail username is required.",
    //       MAIL_PASSWORD: "The mail password is required.",
    //       MAIL_FROM: {
    //           required: "The email address is required.",
    //           email: "Invalid email address."
    //       }
    //   }
    // });


    function initializeValidation(form) {
      form.validate({
        rules: {
          MAIL_INTEGRATION_NAME: {
            required: true
          },
          MAIL_HOST: {
            required: true
          },
          MAIL_PORT: {
            required: true,
            number: true
          },
          MAIL_USERNAME: {
            required: true
          },
          MAIL_PASSWORD: {
            required: true
          },
          MAIL_FROM: {
            required: true,
            email: true
          }
        },
        messages: {
          MAIL_INTEGRATION_NAME: "The mail integration name is required.",
          MAIL_HOST: "The mail host is required.",
          MAIL_PORT: {
            required: "The mail port is required.",
            number: "The mail port must be a number."
          },
          MAIL_USERNAME: "The mail username is required.",
          MAIL_PASSWORD: "The mail password is required.",
          MAIL_FROM: {
            required: "The email address is required.",
            email: "Invalid email address."
          }
        }
      });
    }


    $(document).on("click", "#save-integration-credential-btn", function (e) {
      e.preventDefault();
      initializeValidation($(".create-integration-credential-form"));
      if ($(".create-integration-credential-form").valid()) {

        $("#save-integration-credential-btn").attr('disabled', 'disabled');
        $("#save-integration-credential-btn").text("Sending...");

        //  let formData = $("#create-integration-credential-form").serialize();
        //  console.log(formData);
        let formData = {}; // Initialize an empty object to store form data

        // Iterate through form elements
        $(".create-integration-credential-form").find('input').each(function () {
          let inputName = $(this).attr('name');
          let inputValue = $(this).val();
          formData[inputName] = inputValue; // Add data to the object
        });
        console.log($(".create-integration-credential-form").serialize());
        $.ajax({
          url: "create-integration-credential",
          data: formData,
          type: "post",
          dataType: "json",
          success: function (data) {
            console.log(data);
            if (data == 1) {
              $("#save-integration-credential-btn").removeAttr("disabled");
              $("#save-integration-credential-btn").text("Save");
              $("#integration-credential-modal").modal("hide")
              $("#toasty-success-message .toasty p").text("Your Integration Credential has been saved successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 1500);
            }
            else if (data.error) {
              $("#save-integration-credential-btn").removeAttr("disabled");
              $("#save-integration-credential-btn").text("Save");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 1500);
            }
            else if (data.missing_field) {
              $("#save-integration-credential-btn").removeAttr("disabled");
              $("#save-integration-credential-btn").text("Save");
              $("#toasty-error-message .toasty p").text(data.missing_field);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();

              }, 1500);
            }
            else {
              $("#save-integration-credential-btn").removeAttr("disabled");
              $("#save-integration-credential-btn").text("Save");
              $("#toasty-error-message .toasty p").text("Your Integration Credential is not saved!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();

              }, 1500);
            }
          }
        });
      }
    });

    $(document).on("click", ".integration-credential-delete", function () {
      let token = $(this).data('integration-credential-token');
      $("#integration-credential-token").val(token);
      $("#credential-delete-modal").modal("show")
    });

    $(".integration-credential-delete-btn").click(function (e) {
      let token = $("#integration-credential-token").val();
      $.ajax({
        url: "delete-integration-credential",
        type: "POST",
        data: { token: token },
        success: function (data) {
          // console.log(data);
          if (data == 1) {
            // $("#fields-wrapper .row").remove();
            $("#credential-delete-modal").modal("hide");
            $("#toasty-success-message .toasty p").text("Your Integration Credential has been deleted successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
              location.reload();
            }, 1500);
          }
          // else if (data.error) {
          //   $("#toasty-error-message .toasty p").text(data.error);
          //   $("#toasty-error-message").slideDown();
          //   $("#toasty-success-message").slideUp();
          //   setTimeout(() => {
          //     $("#toasty-error-message").slideUp();
          //     location.reload();
          //   }, 1500);
          // }
          else {
            $("#credential-delete-modal").modal("hide");
            $("#toasty-error-message .toasty p").text("Your Integration Credential is not deleted!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
              location.reload();
            }, 1500);
          }
        }
      });
    });



    $(document).on("click", ".integration-credential-edit", function () {
      let token = $(this).data('integration-credential-token');
      // $("#integration-credential-token").val(token);
      console.log(token);

      $.ajax({
        url: "edit-integration-credential",
        type: "POST",
        data: { token: token },
        success: function (data) {
          console.log(data['json_field_value']);

          // $("#integration-credential-modal .modal-body").html("");
          // $("#integration-credential-modal .modal-body form").attr('class','create-integration-credential-form');

          let output = `
          <div class='row'>
          <input type='hidden' name='token' value='${data['token']}'>`;

          for (let key in data['json_field_value']) {
            if (data['json_field_value'][key]['label'] === 'Mail Password') {
              output += `<div class='col-md-6'><label>${data['json_field_value'][key]['label']}</label><input type='${data['json_field_value'][key]['type']}' id='${data['json_field_value'][key]['name']}' class='form-control' name='${data['json_field_value'][key]['name']}' placeholder='${data['json_field_value'][key]['placeholder']}'></div>`;

            } else {
              output += `<div class='col-md-6'><label>${data['json_field_value'][key]['label']}</label><input type='${data['json_field_value'][key]['type']}' id='${data['json_field_value'][key]['name']}' class='form-control' name='${data['json_field_value'][key]['name']}' value='${data['json_field_value'][key]['value']}' placeholder='${data['json_field_value'][key]['placeholder']}'></div>`;

            }

          }
          output += `</div>`;
          $("#integration-credential-modal form").addClass('update-integration-credential-form');
          $("#integration-credential-modal form").removeClass('create-integration-credential-form');
          $("#integration-credential-modal .modal-footer button:last").attr('id', 'update-integration-credential-btn');
          $("#integration-credential-modal .modal-footer button:last").addClass('btn-success');
          $("#update-integration-credential-btn").text("Update");
          $("#integration-credential-modal form .modal-body").html(output);
          $("#integration-credential-modal h1").text("Edit Integration Credential");
          $("#integration-credential-modal").modal('show')
          // $("#integration-credential-modal .modal-body").html("</form>");


          console.log(output);
        }
      });
    });

    function updatefieldvalidation(form) {
      form.validate({
        rules: {
          MAIL_INTEGRATION_NAME: {
            required: true
          },
          MAIL_HOST: {
            required: true
          },
          MAIL_PORT: {
            required: true,
            number: true
          },
          MAIL_USERNAME: {
            required: true
          },
          MAIL_PASSWORD: {
            required: true
          },
          MAIL_FROM: {
            required: true,
            email: true
          }
        },
        messages: {
          MAIL_INTEGRATION_NAME: "The mail integration name is required.",
          MAIL_HOST: "The mail host is required.",
          MAIL_PORT: {
            required: "The mail port is required.",
            number: "The mail port must be a number."
          },
          MAIL_USERNAME: "The mail username is required.",
          MAIL_PASSWORD: "The mail password is required.",
          MAIL_FROM: {
            required: "The email address is required.",
            email: "Invalid email address."
          }
        }
      });
    }


    $(document).on("click", "#update-integration-credential-btn", function (e) {
      e.preventDefault();
      updatefieldvalidation($(".update-integration-credential-form"));
      if ($(".update-integration-credential-form").valid()) {


        $("#update-integration-credential-btn").attr('disabled', 'disabled');
        $("#update-integration-credential-btn").text("Updating...");
        // let formData = $("#update-integration-credential-form").serialize();
        // console.log(formData);
        // let formData = {}; // Initialize an empty object to store form data

        // // Iterate through form elements
        // $("#integration-credential-modal").find('input').each(function() {
        //     let inputName = $(this).attr('name');
        //     let inputValue = $(this).val();
        //     formData[inputName] = inputValue; // Add data to the object
        // });
        // console.log(formData);


        console.log($(".update-integration-credential-form").serialize());

        $.ajax({
          url: "update-integration-credential",
          type: "post",
          data: $(".update-integration-credential-form").serialize(),
          dataType: "json",
          success: function (data) {
            // console.log(data);
            if (data == 1) {
              // $("#fields-wrapper .row").remove();
              $("#update-integration-credential-btn").removeAttr("disabled");
              $("#update-integration-credential-btn").text("Update");
              $("#credential-edit-modal").modal("hide");
              $("#toasty-success-message .toasty p").text("Your Integration Credential has been updated successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
                location.reload();
              }, 1500);
            }
            else if (data.error) {
              $("#update-integration-credential-btn").removeAttr("disabled");
              $("#update-integration-credential-btn").text("Update");
              $("#toasty-error-message .toasty p").text(data.error);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
            else if (data.error_missing) {
              $("#update-integration-credential-btn").removeAttr("disabled");
              $("#update-integration-credential-btn").text("Update");
              $("#toasty-error-message .toasty p").text(data.error_missing);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
            else {
              $("#update-integration-credential-btn").removeAttr("disabled");
              $("#update-integration-credential-btn").text("Update");
              $("#toasty-error-message .toasty p").text("Your Integration Credential is not updated!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
                location.reload();
              }, 1500);
            }
          }
        });

      }
    });


    function loadCampaign() {
      $.ajax({
        url: "all-campaigns",
        type: "post",
        dataType: "json",
        success: function (data) {
          console.log(data);
          let output = ``;
          let i = 0;
          if (data == 0) {
            output += `
              <tr>
                  <td colspan="8">
                      <div class="d-flex justify-content">
                          <p class="text-md font-weight-bold mt-3 mx-auto">No Campaigns entry found in the System</p>
                      </div>
                  </td>
              </tr>
            `;
            $("#campaigns").html(output);
          } else {
            for (const key in data) {
              i++;
              backendDateTime = new Date(data[key]['date'] + ' ' + data[key]['time']);
              var formattedDateTime = backendDateTime.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true,
              });


              output += `<tr>
            <td class="ps-4">
              <p class="text-xs font-weight-bold mb-0">${i}</p>
            </td>
            <td class="text-center">
              <p class="text-xs font-weight-bold mb-0">${data[key]['campaign_name']}</p>
            </td>
            <td class="text-center">
              <p class="text-xs font-weight-bold mb-0">${data[key]['campaign_leads_count']}</p>
            </td>`;

              if (data[key]['status'] == 'pending') {
                output += `<td class="align-middle text-center text-sm">
              <span class="badge badge-sm bg-gradient-warning">${data[key]['status']}</span>
            </td>`;
              } else if (data[key]['status'] == 'sending') {
                output += `<td class="align-middle text-center text-sm">
              <span class="badge badge-sm bg-gradient-info">${data[key]['status']}</span>
            </td>`;
              }
              else if (data[key]['status'] == 'sent') {
                output += `<td class="align-middle text-center text-sm">
              <span class="badge badge-sm bg-gradient-success">${data[key]['status']}</span>
            </td>`;
              }

              output += `<td class="text-center">
              <span class="text-secondary text-xs font-weight-bold">${data[key]['campaign_timezone']['name']}` + ` ` + `${formattedDateTime}</span>
            </td>`;

          //   <button class="campaign-menu-btn duplicate-campaign" data-campaign-token="${data[key]['token']}">
          //   <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M208 0H332.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9V336c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128h80v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z"/></svg>
          //   Duplicate
          // </button>
              if (data[key]['status'] == 'sending' || data[key]['status'] == 'sent') {
                output += `<td class="align-middle text-center">
              <div class="dropdowne">
                  <button class="dropdown-btn"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 128 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg></button>
                <div class="dropdown-content">
                  <div class="campaign-menu-btn-group">
                  <button class="campaign-delete-btn campaign-menu-btn campaign-delete" data-campaign-token="${data[key]['token']}">
                    <svg class="" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                    Delete
                  </button>
                  </div>
                </div>
              </div>
            </td>`;
              } else {

                output += `<td class="align-middle text-center">
              <div class="dropdowne">
                  <button class="dropdown-btn"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 128 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"/></svg></button>
                <div class="dropdown-content">
                  <div class="campaign-menu-btn-group">
                  <button class="campaign-edit-btn campaign-menu-btn campaign-edit" data-campaign-token="${data[key]['token']}">
                    <svg class="" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                    Edit
                  </button>`;
                if (data[key]['is_active'] == 0) {
                  output += `
                            <button class="campaign-menu-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-352a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                            <span class="text-danger clickable" title="InActive campaign will not be sent!" data-campaign-token='${data[key]['token']}'>InActive</span>
                            </button>`;
                } else {
                  output += `
                            <button class="campaign-menu-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-352a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                            <span class="text-success clickable" title="Active campaign will be sent!" data-campaign-token='${data[key]['token']}'>Active</span>
                            </button>`;
                }

                output += `
                 <button class="campaign-menu-btn duplicate-campaign" data-campaign-token="${data[key]['token']}">
                 <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M208 0H332.1c12.7 0 24.9 5.1 33.9 14.1l67.9 67.9c9 9 14.1 21.2 14.1 33.9V336c0 26.5-21.5 48-48 48H208c-26.5 0-48-21.5-48-48V48c0-26.5 21.5-48 48-48zM48 128h80v64H64V448H256V416h64v48c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V176c0-26.5 21.5-48 48-48z"/></svg>
                 Duplicate
               </button>
                 <button class="campaign-delete-btn campaign-menu-btn campaign-delete" data-campaign-token="${data[key]['token']}">
                    <svg class="" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                    Delete
                  </button>
                  </div>
                </div>
              </div>

            </td>`;
              }

              output += `</tr>`;
            }
          }


          $("#campaigns").html(output);

        }
      });
    }

    loadCampaign();

    $(document).on("click", ".dropdown-btn", function (event) {
      event.preventDefault();
      const dropdown = $(this).closest(".dropdowne");
      closeAllMenusExcept(dropdown); // Close all menus except the clicked one
      dropdown.toggleClass("open");
      event.stopPropagation(); // Prevent the click from closing the menu immediately
    });

    // Add a click event listener to the document to close all menus when clicking outside of them
    $(document).click(function (event) {
      closeAllMenusExcept(null); // Close all menus
    });

    function closeAllMenusExcept(exceptDropdown) {
      const openMenus = $(".dropdowne.open");
      openMenus.each(function () {
        if (!$(this).is(exceptDropdown)) {
          $(this).removeClass("open");
        }
      });
    }

    $(".edite").click(function (event) {
      event.preventDefault();
      event.stopPropagation();
      console.log("Hello, you clicked on an edit button.");
    });

    // const dropdownButtons = document.querySelectorAll(".dropdown-btn");

    //   dropdownButtons.forEach(function (dropdownButton) {
    //       dropdownButton.addEventListener("click", function (event) {
    //           event.preventDefault();
    //           const dropdown = dropdownButton.closest(".dropdowne");
    //           closeAllMenusExcept(dropdown); // Close all menus except the clicked one
    //           dropdown.classList.toggle("open");
    //           event.stopPropagation(); // Prevent the click from closing the menu immediately
    //       });
    //   });

    //   // Add a click event listener to the document to close all menus when clicking outside of them
    //   document.addEventListener("click", function (event) {
    //       closeAllMenusExcept(null); // Close all menus
    //   });

    //   function closeAllMenusExcept(exceptDropdown) {
    //       const openMenus = document.querySelectorAll(".dropdowne.open");
    //       openMenus.forEach(function (openMenu) {
    //           if (openMenu !== exceptDropdown) {
    //               openMenu.classList.remove("open");
    //           }
    //       });
    //   }

    //   const editButtons = document.querySelectorAll(".edit");
    //   editButtons.forEach(function (editButton) {
    //       editButton.addEventListener("click", function (event) {
    //           event.preventDefault();
    //           console.log("Hello, you clicked on an edit button.");
    //       });
    //   });




    $(document).on("click", ".clickable", function (e) {

      $.ajax({
        url: "/change-active/" + $(this).data('campaign-token'),
        type: "post",
        dataType: "json",
        success: function (data) {
          loadCampaign();
          console.log(data);
        }
      });

    });


    var timezones;
    $("#create-campaign-btn").on("click", function (e) {
      $.ajax({
        url: "/create-campaign",
        type: "post",
        // dataType: "json",
        success: function (data) {
          console.log(data);
           timezones = data['timezones'];
          console.log(timezones);
          let output = ``;
          output += `<div class="row">`

          output += `<div class="col-md-12">
              <label for="">Campaign Name:</label>
              <input type="text" class="form-control" id="campaign_name" name="campaign_name" placeholder="Campaign Name...">
          </div>`

          output += `<div class="col-md-12">
          <label for="">Choose Template</label>
          <select class="form-select" name="choose_template" id="template_token">
              <option disabled selected>Choose template</option>`;
          for (key in data['templates']) {
            console.log(data['templates'][key]['token']);
            output += `<option value="${data['templates'][key]['token']}">${data['templates'][key]['campaign_template_name']}</option>`;
          }

          output += `</select>
          </div>`;

          output += `<div class="col-md-12">
              <label for="">Choose List</label>
              <select class="form-select" name="choose_list" id="list_token">
                  <option disabled selected>Choose list</option>`;
          for (key in data['csvlists']) {
            console.log(data['csvlists'][key]['token']);
            output += `<option value="${data['csvlists'][key]['token']}">${data['csvlists'][key]['list_name']}</option>`;
          }

          output += `</select>
          </div>`;

          output += `<div class="col-md-12">
          <label>Choose Service</label>
            <select class="form-select" name="choose_credential" id="credential_token">
              <option disabled selected>Choose Credential</option>`;
          for (key in data['integrations']) {
            console.log(data['integrations'][key]['token']);
            let integration_name = JSON.parse(data['integrations'][key]['json_field_value']);
            output += `<option value="${data['integrations'][key]['token']}">${integration_name[key]['MAIL_INTEGRATION_NAME']}</option>`;
          }
          output += `</select>
          </div>`;
          output+=`
          <div class="mt-3">
            <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="campaign_radio" id="campaign-schedule" value="schedule">
  <label class="form-check-label" for="campaign-schedule">
    Schedule
  </label>
</div>       
          </div>
          `;
/* <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="campaign_radio" id="campaign-sendnow" value='send-now'>
  <label class="form-check-label" for="campaign-sendnow">
    Send Now
  </label>
</div> */

          output += `<div id="optional-fields"></div>
          
          </div>
          <button type="submit" class="btn btn-sm btn-dark my-2" id="campaign-preview">Preview</button>`;

          $("#campaign-modal .modal-dialog .modal-content").wrapInner("<div class='create-campaign-content' id='create-campaign-content'></div>");
          $("#campaign-modal #create-campaign-content").after("<div class='preview-campaign-content' id='preview-campaign-content'><div class='modal-header'><h1 class='modal-title fs-5' id='staticBackdropLabel'>Campaign Preview</h1><button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button></div><div class='modal-body' ><div id='preview-area'><div class='email'><h2>Email Subject</h2><p class='sender'>Sender Name &lt;sender@example.com&gt;</p><p class='timestamp'>Received: September 9, 2023 10:00 AM</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam vel est eu velit hendrerit venenatis.</p></div></div></div><div class='modal-footer'><button type='button' class='btn btn-secondary' id='close-preview-campaign-btn'>Close</button></div></div>");
          $("#campaign-modal form").addClass("create-campaign-form");
          $("#campaign-modal form .modal-body").html(output);
          $("#campaign-modal .modal-title.create-campaign-title").text("Create Campaign");
          $("#campaign-modal .modal-footer .campaign-save-btn").attr('id', 'save-campaign-btn');
          $("#save-campaign-btn").addClass("btn-primary");
          $("#save-campaign-btn").text("Create");
          $("#campaign-modal").modal("show");
          console.log(output);
        }
      });
    });

     // Function to remove fields when "Send Now" is selected
  function removeFields() {
    $("#optional-fields").empty();
  }

  // Initial state
  function createFields() {
    output = ``;
    output += `<div class="row"><div class="col-md-6">
    <label>Choose Date</label>
    <input type="date" class="form-control date" name="date">
    </div>
    <div class="col-md-6">
      <label>Choose Time</label>
      <input type="time" class="form-control" id="time" name="time">
    </div>`

output += `<div class="col-md-12">
<label>Choose Timezone</label>
<select class="form-select" name="choose_timezone" id="timezone">
    <option disabled selected>Choose Timezone</option>`;
for (key in timezones) {
  output += `<option value='${timezones[key]['id']}'>${timezones[key]['name']}` + `  ` + `${timezones[key]['offset'].substr(0,6)}</option>`
}
output += `</select>
</div></div>`;
$("#optional-fields").html(output);
  }

  // Event handler for radio button change
  $(document).on("change","input[type='radio']",function () {
    const selectedValue = $(this).val();

    if (selectedValue === "schedule") {
      createFields();

      console.log("schedule");
    } else if (selectedValue === "send-now") {
      removeFields();
      console.log("send now");
    }
  });
// });

  //   $(document).on("click","#campaign-schedule" ,function () {
  //     console.log(timezones);
  //     output = ``;
  //     console.log("hello g");

  //     output += `<div class="row"><div class="col-md-6">
  //     <label>Choose Date</label>
  //     <input type="date" class="form-control date" name="date">
  //     </div>
  //     <div class="col-md-6">
  //       <label>Choose Time</label>
  //       <input type="time" class="form-control" id="time" name="time">
  //     </div>`

  // output += `<div class="col-md-12">
  // <label>Choose Timezone</label>
  // <select class="form-select" name="choose_timezone" id="timezone">
  //     <option disabled selected>Choose Timezone</option>`;
  // for (key in timezones) {
  //   output += `<option value='${timezones[key]['id']}'>${timezones[key]['name']}` + `  ` + `${timezones[key]['offset'].substr(0,6)}</option>`
  // }
  // output += `</select>
  // </div></div>`;
  // $("#optional-fields").html(output);

  //   });


    function previewCampaignValidation(form) {
      form.validate({
        rules: {
          choose_template: {
            required: true
          },
          choose_list: {
            required: true
          },
          choose_credential: {
            required: true
          }
        },
        messages: {
          choose_template: "Please choose the template.",
          choose_list: "Please choose the list.",
          choose_credential: "Please choose the credential."
        }
      });
    }

    $(document).on("click","#campaign-preview", function (e) {
      e.preventDefault();
      previewCampaignValidation($(".create-campaign-form"));
      // if ($("#list_token").val() != null && $("#template_token").val() != null && $("#credential_token").val() != null) {
        
      // } else {
        
      // }
      if ($(".create-campaign-form").valid()) {
      $("#campaign-modal .modal-content").addClass("active");
      $.ajax({
        url: "campaign-preview/"+$("#list_token").val()+"/"+$("#template_token").val()+"/"+$("#credential_token").val(),
        type: "post",
        success: function (data) {
          console.log(data);
          if (data != 0) { 
            $("#campaign-modal .modal-content #preview-area .email h2").text(`${data['subject']}`);
            $("#campaign-modal .modal-content #preview-area .sender").text(`${data['sender_name']}`+`<`+`${data['mail_from']}`+`>`);
            $("#campaign-modal .modal-content #preview-area .timestamp+p").html(`${data['body']}`);
          } else {
            $("#toasty-error-message .toasty p").text("Failed to preview!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 1500);
          }
          }
      });
    }
    });

    $(document).on("click","#close-preview-campaign-btn", function () {
      $("#campaign-modal .modal-content").removeClass("active");
    });

    function createCampaignValidation(form) {
      form.validate({
        rules: {
          campaign_name: {
            required: true
          },
          choose_template: {
            required: true
          },
          choose_list: {
            required: true
          },
          choose_credential: {
            required: true
          }
        },
        messages: {
          campaign_name: "The campaign name is required.",
          choose_template: "Please choose the template.",
          choose_list: "Please choose the list.",
          choose_credential: "Please choose the credential.",
        }
      });
    }


    $(document).on("click", "#save-campaign-btn", function (e) {
      console.log($("#time").val());
      e.preventDefault();
      // createCampaignValidation($(".create-campaign-form"));
      // if ($(".create-campaign-form").valid()) {

        $("#save-campaign-btn").attr("disabled", "disabled");
        $("#save-campaign-btn").text("Creating...");
        console.log($(".create-campaign-form").serialize());
        // campaign_name:$("#campaign_name").val(),
        // choose_template:$("#template_token").val(),
        // choose_list :$("#list_token").val(),
        // choose_credential :$("#credential_token").val(),
        // date :$("#date").val(),
        // time :$("#time").val(),
        // choose_timezone :$("#timezone").val()
        $.ajax({
          url: "/save-campaign",
          type: "post",
          data: $(".create-campaign-form").serialize(),
          dataType: "json",
          success: function (data) {
            console.log(data);
            if (data == 1) {
              loadCampaign();
              $("#campaign-modal").modal("hide");
              $("#save-campaign-btn").removeAttr("disabled");
              $("#save-campaign-btn").text("Create");
              $("#toasty-success-message .toasty p").text("Your campaign has been Saved successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
              }, 1500);
            }
            else if (data.error_missing_field) {
              $("#save-campaign-btn").removeAttr("disabled");
              $("#save-campaign-btn").text("Create");
              $("#toasty-error-message .toasty p").text(data.error_missing_field);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 1500);
            }
            else {
              $("#save-campaign-btn").removeAttr("disabled");
              $("#save-campaign-btn").text("Create");
              $("#toasty-error-message .toasty p").text("Your campaign is not saved!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 1500);
            }
          }
        });
      // }
    });

    $(document).on("click", ".campaign-delete-btn", function (e) {
      $("#campaign-token").val($(this).data('campaign-token'));
      $("#campaign-delete-modal").modal("show");
    });

    $("#campaign-delete-modal .delete").on("click", function (e) {

      $.ajax({
        url: "/delete-campaign/" + $("#campaign-token").val(),
        type: "post",
        success: function (data) {
          if (data == 1) {
            // $("#fields-wrapper .row").remove();
            loadCampaign();
            $("#campaign-delete-modal").modal("hide");
            $("#toasty-success-message .toasty p").text("Your Campaign has been deleted successfully!");
            $("#toasty-success-message").slideDown();
            $("#toasty-error-message").slideUp();
            setTimeout(() => {
              $("#toasty-success-message").slideUp();
            }, 1500);
          }
          // else if (data.error) {
          //   $("#toasty-error-message .toasty p").text(data.error);
          //   $("#toasty-error-message").slideDown();
          //   $("#toasty-success-message").slideUp();
          //   setTimeout(() => {
          //     $("#toasty-error-message").slideUp();
          //     location.reload();
          //   }, 1500);
          // }
          else {
            $("#campaign-delete-modal").modal("hide");
            $("#toasty-error-message .toasty p").text("Your campaign is not deleted!");
            $("#toasty-error-message").slideDown();
            $("#toasty-success-message").slideUp();
            setTimeout(() => {
              $("#toasty-error-message").slideUp();
            }, 1500);
          }
        }
      });
    });


    $(document).on("click", ".campaign-edit-btn", function (e) {

      $.ajax({
        url: "/edit-campaign/" + $(this).data('campaign-token'),
        type: "post",
        success: function (data) {
          console.log(data);
          let output = ``;
          output += `<div class="row">`
          output += `<input type='hidden' name='token' value='${data['edit_campaign']['token']}'>`
          output += `<div class="col-md-12">
              <label for="">Campaign Name:</label>
              <input type="text" class="form-control" id="campaign_name" name="campaign_name" value='${data['edit_campaign']['campaign_name']}' placeholder="Campaign Name...">
          </div>`

          output += `<div class="col-md-12">
          <label for="">Choose Template</label>
          <select class="form-select" name="choose_template" id="template_token">
              <option disabled selected>Choose template</option>`;
          for (key in data['templates']) {
            console.log(data['templates'][key]['token']);
            if (data['edit_campaign']['campaign_template_id'] == data['templates'][key]['id']) {
              output += `<option value="${data['templates'][key]['token']}" selected >${data['templates'][key]['campaign_template_name']}</option>`;
            } else {
              output += `<option value="${data['templates'][key]['token']}">${data['templates'][key]['campaign_template_name']}</option>`;
            }
          }

          output += `</select>
          </div>`;

          output += `<div class="col-md-12">
              <label for="">Choose List</label>
              <select class="form-select" name="choose_list" id="list_token">
                  <option disabled selected>Choose list</option>`;
          for (key in data['csvlists']) {
            console.log(data['csvlists'][key]['token']);
            if (data['edit_campaign']['csv_list_id'] == data['csvlists'][key]['id']) {
              output += `<option value="${data['csvlists'][key]['token']}" selected >${data['csvlists'][key]['list_name']}</option>`;
            } else {
              output += `<option value="${data['csvlists'][key]['token']}">${data['csvlists'][key]['list_name']}</option>`;
            }
          }

          output += `</select>
          </div>`;

          output += `<div class="col-md-12">
          <label>Choose Service</label>
            <select class="form-select" name="choose_credential" id="credential_token">
              <option disabled selected>Choose service</option>`;
          for (key in data['integrations']) {
            console.log(data['integrations'][key]['token']);
            let integration_name = JSON.parse(data['integrations'][key]['json_field_value']);
            if (data['edit_campaign']['integration_credential_id'] == data['integrations'][key]['id']) {
              output += `<option value="${data['integrations'][key]['token']}" selected >${integration_name[key]['MAIL_INTEGRATION_NAME']}</option>`;
            } else {
              output += `<option value="${data['integrations'][key]['token']}">${integration_name[key]['MAIL_INTEGRATION_NAME']}</option>`;
            }
          }
          output += `</select>
          </div>`;

          output += `<div class="col-md-6">
              <label>Choose Date</label>
              <input type="date" class="form-control date" name="date" value='${data['edit_campaign']['date']}'>
              </div>
              <div class="col-md-6">
                <label>Choose Time</label>
                <input type="time" class="form-control" id="time" name="time" value='${data['edit_campaign']['time']}'>
              </div>`

          output += `<div class="col-md-12">
          <label>Choose Timezone</label>
          <select class="form-select" name="choose_timezone" id="timezone">
              <option disabled selected>Choose Timezone</option>`;
          for (key in data['timezones']) {
            if (data['edit_campaign']['timezone_id'] == data['timezones'][key]['id']) {
              output += `<option value='${data['timezones'][key]['id']}' selected >${data['timezones'][key]['name']}` + `  ` + `${data['timezones'][key]['offset']}</option>`
            } else {
              output += `<option value='${data['timezones'][key]['id']}'>${data['timezones'][key]['name']}` + `  ` + `${data['timezones'][key]['offset']}</option>`
            }
          }
          output += `</select>
          </div>`;
          output += `</div>`;

          console.log(output);
          $("#campaign-modal form").addClass("update-campaign-form")
          $("#campaign-modal form .modal-body").html(output);
          $("#campaign-modal h1").text("Edit Campaign");
          $("#campaign-modal .modal-footer button:last").attr('id', 'update-campaign-btn');
          $("#update-campaign-btn").addClass("btn-success");
          $("#update-campaign-btn").text("Update");
          $("#campaign-modal").modal("show");
        }
      })
    });


    function updateCampaignValidation(form) {
      form.validate({
        rules: {
          campaign_name: {
            required: true
          },
          choose_template: {
            required: true
          },
          choose_list: {
            required: true
          },
          choose_credential: {
            required: true
          },
          date: {
            required: true
          },
          time: {
            required: true
          },
          choose_timezone: {
            required: true
          },
        },
        messages: {
          campaign_name: "The campaign name is required.",
          choose_template: "Please choose the template.",
          choose_list: "Please choose the list.",
          choose_credential: "Please choose the credential.",
          date: "Please select the date.",
          time: "Please select the time.",
          choose_timezone: "Please choose the timezone.",
        }
      });
    }


    $(document).on("click", "#update-campaign-btn", function (e) {
      e.preventDefault();
      console.log($(".update-campaign-form").serialize());
      updateCampaignValidation($(".update-campaign-form"));
      if ($(".update-campaign-form").valid()) {
        $("#update-campaign-btn").attr("disabled", "disabled");
        $("#update-campaign-btn").text("Updating...");

        $.ajax({
          url: "/update-campaign",
          type: "post",
          data: $(".update-campaign-form").serialize(),
          dataType: "json",
          success: function (data) {
            if (data == 1) {
              // $("#fields-wrapper .row").remove();
              loadCampaign();
              $("#update-campaign-btn").removeAttr("disabled");
              $("#update-campaign-btn").text("Update");
              $("#campaign-modal").modal("hide");
              $("#toasty-success-message .toasty p").text("Your Campaign has been Updated successfully!");
              $("#toasty-success-message").slideDown();
              $("#toasty-error-message").slideUp();
              setTimeout(() => {
                $("#toasty-success-message").slideUp();
              }, 1500);
            }
            else if (data.error_missing_field) {
              $("#update-campaign-btn").removeAttr("disabled");
              $("#update-campaign-btn").text("Update");
              $("#toasty-error-message .toasty p").text(data.error_missing_field);
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 1500);
            }
            else {
              // $("#credential-delete-modal").modal("hide");
              $("#update-campaign-btn").removeAttr("disabled");
              $("#update-campaign-btn").text("Update");
              $("#toasty-error-message .toasty p").text("Your campaign is not Updated!");
              $("#toasty-error-message").slideDown();
              $("#toasty-success-message").slideUp();
              setTimeout(() => {
                $("#toasty-error-message").slideUp();
              }, 1500);
            }
          }
        });
      }
    });

    $("#refresh-campaign-row").click(function () {
      loadCampaign();
    });

  });


  $(document).on("click", ".date", function () {
    const today = new Date().toISOString().split('T')[0];
    // Set the minimum date for the input field to today
    console.log(today);
    $('.date').attr('min', today);
  });


  $(document).on("click", ".duplicate-campaign", function (e) {

    $.ajax({
      url: "/duplicate-campaign/" + $(this).data('campaign-token'),
      type: "post",
      success: function (data) {
        // console.log(data);
        // loadCampaign();
        $("#refresh-campaign-row").click();
      }
    });



  });

}