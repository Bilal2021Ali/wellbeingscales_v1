'use strict';

$('.alert').slideUp();
toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
$('#myModal input').each(function () {
    $(this).on('keypress keydown keyup', function () {
        if ($('input[name="en_title"]').val().length > 0 && $('input[name="ar_title"]').val().length) {
            $('.code').slideDown();
        } else {
            $('.code').slideUp();
        }
    });
});
$('.table').DataTable();
$(".table").on('click', ".upload", function (e) {
    $('#AccountId').attr('value', $(this).attr('data-account-id'));
    $('#file_type').attr('value', $(this).attr('data-file-type'));
    $('#language').attr('value', $(this).attr('data-language'));
    Dropzone.forElement('#fileupload').removeAllFiles(); // remove old files from the upload form
});
$(".table").on('click', ".media_upload", function (e) {
    // category_id
    // language
    $('#add_media_link input[name="category_id"]').attr('value', $(this).attr('data-account-id'));
    $('#add_media_link input[name="language"]').attr('value', $(this).attr('data-language'));
    $('#add_media_link .alert').slideUp();
    $('.linkinput').val('');
    // removing the old inputs
    var count = 0;
    if ($('.linkinput').length > 0) {
        $('.linkinput').each(function () {
            count++;
            if (count !== 1) {
                $(this).parents('.inner').first().remove('');
            }
        });
    } else {
        console.log($('.linkinput').length);
    }
});

$('.floating_action_btn').click(function () {
    $('#myModal').attr('data-for', "Creat");
    $('#myModalLabel').html('Add a Category');
    setOldDataInInputs();
});

$("#update_resources").on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: base_url + 'index.php/EN/Consultant/Upload_Category_resources',
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            console.log(data.status);
            if (data.status == "ok") {
                Swal.fire({
                    title: 'Added !',
                    text: 'The resource has been Added .',
                    icon: 'success'
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                $('#uploadresorces .alert').html(data.messages.error);
                $('#uploadresorces .alert').slideDown();
            }
        },
        ajaxError: function () {
            $('#StatusBox').css('background-color', '#B40000');
            $('#StatusBox').html("Ooops! Error was found.");
        }
    });
});

function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

$("#media_link").on('submit', function (e) {
    e.preventDefault();
    $('.inner .error').html(''); // reset errors messages
    var $this = $(this);
    var errors = 0;
    var data = new FormData(this);
    var oldLinks = [];
    $('.linkinput').each(function () {
        var val = $(this).val();
        if (!isUrlValid(val)) {
            errors++;
            $(this).parents('.inner').first().children().find(".error").html("Please enter valid url");
            // $(this).parents('.inner').first().children('.error').html();
            console.log("error");
        }
        if (oldLinks.includes(val)) {
            errors++;
            $('#add_media_link .alert').slideDown();
            $('#add_media_link .alert').html("Please don't enter duplicated values");
        } else {
            oldLinks.push(val)
        }
    });
    if (errors == 0) {
        $($this).children().find('button[type="Submit"]').attr('disabled', '');
        $($this).children().find('button[type="Submit"]').html('Please wait...');
        $.ajax({
            type: 'POST',
            url: base_url + 'index.php/EN/Consultant/Upload_media_link/' + type,
            data: data,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $($this).children().find('button[type="Submit"]').removeAttr('disabled');
                $($this).children().find('button[type="Submit"]').html('save');
                console.log(data.status);
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Added !',
                        text: 'The resource has been Added .',
                        icon: 'success'
                    });
                    setTimeout(() => {
                        $('#add_media_link').modal('hide');
                    }, 1000);
                } else {
                    $('#add_media_link .alert').html(data.messages.error);
                    $('#add_media_link .alert').slideDown();
                }
            },
            ajaxError: function () {
                $('#StatusBox').css('background-color', '#B40000');
                $('#StatusBox').html("Ooops! Error was found.");
            }
        });
    }
});


function setOldDataInInputs(data = []) {
    if (Object.keys(data).length > 0) { // when there is new data
        // en edition
        $('#myModal input[name="Title_EN"]').attr('value', data.Cat_en);
        $('#myModal input[name="Action_EN"]').attr('value', data.action_name_en);
        $('#myModal input[name="Report_EN"]').attr('value', data.report_name_en);
        $('#myModal input[name="Media_EN"]').attr('value', data.media_name_en);
        $('#myModal input[name="Media_EN"]').attr('value', data.media_name_en);
        // Ar edition
        $('#myModal input[name="Title_AR"]').attr('value', data.Cat_ar);
        $('#myModal input[name="Action_AR"]').attr('value', data.action_name_ar);
        $('#myModal input[name="Report_AR"]').attr('value', data.report_name_ar);
        $('#myModal input[name="Media_AR"]').attr('value', data.media_name_ar);
        $('#myModal input[name="Media_AR"]').attr('value', data.media_name_ar);
    } else {
        // en edition
        $('#myModal input[name="Title_EN"]').attr('value', "");
        $('#myModal input[name="Action_EN"]').attr('value', "");
        $('#myModal input[name="Report_EN"]').attr('value', "");
        $('#myModal input[name="Media_EN"]').attr('value', "");
        $('#myModal input[name="Media_EN"]').attr('value', "");
        // Ar edition
        $('#myModal input[name="Title_AR"]').attr('value', "");
        $('#myModal input[name="Action_AR"]').attr('value', "");
        $('#myModal input[name="Report_AR"]').attr('value', "");
        $('#myModal input[name="Media_AR"]').attr('value', "");
        $('#myModal input[name="Media_AR"]').attr('value', "");
    }
}

// Add restrictions
Dropzone.options.fileupload = {
    acceptedFiles: 'image/*,application/pdf,.psd',
    maxFilesize: 50, // MB ,
};
$(".table").on('click', ".able_to_download", function (e) {
    $('.listofFiles').html('Please wait ....');
    const AccountId = $(this).parents("td").children().first(".upload").children().attr("data-account-id");
    const AccountType = type;
    const language = $(this).parents("td").children().first(".upload").children().attr("data-language");
    const file_type = $(this).parents("td").children().first(".upload").children().attr("data-file-type");
    $.ajax({
        type: 'POST',
        url: base_url + 'index.php/EN/Consultant/Upload_Category_resources',
        data: {
            AccountId: AccountId,
            AccountType: AccountType,
            language: language,
            file_type: file_type,
        },
        success: function (data) {
            $('.listofFiles').html('');
            console.log(data.status);
            if (data.status == "ok") {
                if (data.list.length > 0) {
                    data.list.forEach(file => {
                        var new_html = "";
                        new_html += '<div class="col-md-6 col-xl-4">';
                        new_html += '<div class="card">';
                        new_html += '<i class="uil uil-trash delete" data-file-id="' + file.Id + '" ></i>';
                        new_html += '<label class="switch">';
                        new_html += '<input type="checkbox" class="FileStatus"  ' + (file.status == "1" ? 'checked' : '') + ' data-file-id="' + file.Id + '">';
                        new_html += '<span class="slider round"></span>';
                        new_html += '</label>';
                        new_html += '<div class="avatar-lg mx-auto mb-4 mt-5"> <div class="avatar-title bg-soft-primary rounded-circle text-primary"><i class="mdi mdi-file-chart display-4 m-0 text-primary"></i> </div></div>';
                        if (file.file_type == "1") {
                            new_html += '<h6 class="text-center"><a href="' + base_url + 'uploads/Category_resources/' + file.file_language + '/' + file.file_url + '">File link</a></h6>';
                        } else {
                            new_html += '<h6 class="text-center"><a href="' + base_url + 'uploads/Reports_resources/' + file.file_language + '/' + file.file_url + '">File link</a></h6>';
                        }
                        new_html += '<div class="card-body">';
                        if (file.file_language == "EN") {
                            new_html += '<input type="text" name="title" data-file-id="' + file.Id + '" value="' + file.file_name_en + '" class="form-control mb-1 titleinput">';
                        } else {
                            new_html += '<input type="text" name="title" data-file-id="' + file.Id + '" value="' + file.file_name_ar + '" class="form-control mb-1 titleinput">';
                        }
                        new_html += '<span class="error text-error"></span>'
                        new_html += '<button type="button" class="btn btn-success waves-effect waves-light w-100 mt-1 hidden" data-file-id="' + file.Id + '" data-file-lang="' + file.file_language + '" >update</button>';
                        new_html += '</div></div></div>';
                        $('.listofFiles').append(new_html);
                    });
                } else {
                    $('.listofFiles').html('<h3>No data Found</h3>')
                }
            } else {
                Swal.fire({
                    title: 'sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error'
                });
            }
        },
        ajaxError: function () {
            $('#StatusBox').css('background-color', '#B40000');
            $('#StatusBox').html("Ooops! Error was found.");
        }
    });
});

var new_val = "";
var id = '';
var title_language = '';
$('.listofFiles').on('keyup', '.titleinput', function () {
    new_val = $(this).val();
    id = $(this).attr('data-file-id');
    title_language = $(this).attr('data-title-language');
    if (new_val.length > 3) {
        $(this).removeClass('parsley-error');
        $(this).parents().children('.error').html("");
        $(this).parents().children('.btn-success').removeClass("hidden");
        $(".titleinput btn-success").addClass("hidden");
    } else {
        $(this).addClass('parsley-error');
        $(this).parents().children('.error').html("this title is very short, please write 3 characters at least");
        $(this).parents().children('.btn-success').addClass("hidden");
        $(".titleinput btn-success").removeClass("hidden");
    }
});

$('.listofFiles').on('click', '.btn-success', function () {
    var $this = $(this);
    $.ajax({
        type: 'POST',
        url: base_url + 'index.php/EN/Consultant/update_Category_resource_title',
        data: {
            file_id: $(this).attr('data-file-id'),
            new_title: new_val,
            language: $(this).attr("data-file-lang"),
        },
        success: function (data) {
            if (data.status == "ok") {
                $($this).html('updeted successfully <i class="uil uil-check"></i>');
                setTimeout(function () {
                    $($this).addClass('hidden');
                }, 800);
            } else {
                Swal.fire({
                    title: 'sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error'
                });
            }
        },
        ajaxError: function () {
            $('#StatusBox').css('background-color', '#B40000');
            $('#StatusBox').html("Ooops! Error was found.");
        }
    });
});

$('.listofFiles').on('click', '.delete', function () {
    var file_id = $(this).attr('data-file-id');
    var $this = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mt-2',
        cancelButtonClass: 'btn btn-danger ms-2 mt-2',
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: 'DELETE',
                url: base_url + 'index.php/EN/Consultant/update_Category_resource_title',
                data: {
                    file_id: file_id,
                },
                success: function (data) {
                    if (data.status == "ok") {
                        $($this).parents('.col-md-6.col-xl-4').slideUp();
                        setTimeout(() => {
                            $($this).remove();
                        }, 800);
                    } else {
                        Swal.fire({
                            title: 'sorry !',
                            text: 'We have an error in processing this request',
                            icon: 'error'
                        });
                    }
                },
                ajaxError: function () {
                    $('#StatusBox').css('background-color', '#B40000');
                    $('#StatusBox').html("Ooops! Error was found.");
                }
            });
        }
    });
});

$('.table').on('click', '.able_to_open', function () {
    const linkId = $(this).parents("td").children().first(".media_upload").children().attr("data-account-id");
    const language = $(this).parents("td").children().first(".media_upload").children().attr("data-language");
    $.ajax({
        type: 'POST',
        url: base_url + 'index.php/EN/Consultant/medialinks/' + type,
        data: {
            category: linkId,
            language: language,
        },
        success: function (data) {
            $('.medialinkslist').html('');
            console.log(data.status);
            if (data.status == "ok") {
                console.log(data.list);
                if (data.list.length > 0) {
                    data.list.forEach(media => {
                        var youtube_video_id = media.link.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
                        var new_html = '';
                        new_html += '<div class="col-md-6 col-xl-4">';
                        new_html += '<div class="card">';
                        new_html += '<i class="uil uil-trash delete" data-link-id="' + media.Id + '"></i>';
                        new_html += '<label class="switch">';
                        new_html += '<input type="checkbox" class="MediaStatus"  ' + (media.status == "1" ? 'checked' : '') + ' data-file-id="' + media.Id + '">';
                        new_html += '<span class="slider round"></span>';
                        new_html += '</label>';
                        new_html += '<img class="card-img-top img-fluid" src="https://img.youtube.com/vi/' + youtube_video_id + '/0.jpg">';
                        new_html += '<div class="card-body">';
                        new_html += '<p data-link-id="' + media.Id + '">' + media.title + '</p>';
                        new_html += '<a href="' + media.link + '" target="_blank" class="btn btn-primary waves-effect waves-light w-100 mt-1">open</a>';
                        new_html += '</div></div></div>';
                        $('.medialinkslist').append(new_html);
                    });
                } else {
                    $('.medialinkslist').html('<h3> No Links Found </h3>')
                }
            } else {
                Swal.fire({
                    title: 'sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error'
                });
            }
        },
        ajaxError: function () {
            $('#StatusBox').css('background-color', '#B40000');
            $('#StatusBox').html("Ooops! Error was found.");
        }
    });
});

$('.medialinkslist').on('click', '.delete', function () {
    var LinkId = $(this).attr('data-link-id');
    var $this = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mt-2',
        cancelButtonClass: 'btn btn-danger ms-2 mt-2',
        buttonsStyling: false
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                type: 'DELETE',
                url: base_url + 'index.php/EN/Consultant/medialinks',
                data: {
                    linkId: LinkId,
                },
                success: function (data) {
                    if (data.status == "ok") {
                        $($this).parents('.col-md-6.col-xl-4').slideUp();
                        setTimeout(() => {
                            $($this).remove();
                        }, 800);
                    } else {
                        Swal.fire({
                            title: 'sorry !',
                            text: 'We have an error in processing this request',
                            icon: 'error'
                        });
                    }
                },
                ajaxError: function () {
                    $('#StatusBox').css('background-color', '#B40000');
                    $('#StatusBox').html("Ooops! Error was found.");
                }
            });
        }
    });
});


$(".medialinkslist").on("change", ".MediaStatus", function () {
    const LinkId = $(this).data("file-id");
    $.ajax({
        type: 'PUT',
        url: base_url + 'index.php/EN/Consultant/medialinks/' + LinkId,
        success: function (data) {
            if (data.trim() !== "ok") {
                Swal.fire({
                    title: 'sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error'
                });
            }
        },
        ajaxError: function () {
            $('#StatusBox').css('background-color', '#B40000');
            $('#StatusBox').html("Ooops! Error was found.");
        }
    });
});


$('.listofFiles').on('change', '.FileStatus', function () {
    var fileId = $(this).attr('data-file-id');
    $.ajax({
        type: "PUT",
        url: base_url + "index.php/EN/Consultant/Upload_Category_resources",
        data: {
            id: fileId
        },
        success: function (response) {
            if (response == "error") {
                alert('Sorry we have an error , please try again later');
            }
        }
    });
});
/**                */
// $('.listofFiles').on('change', '.MediaStatus', function () {
//     var fileId = $(this).attr('data-file-id');
//     $.ajax({
//         type: "PUT",
//         url: base_url + "index.php/EN/Consultant/medialinks",
//         data: {
//             id: fileId
//         },
//         success: function (response) {
//             if (response == "error") {
//                 alert('Sorry we have an error , please try again later');
//             }
//         }
//     });
// });

$('.icon-upload').click(function () {
    var id = $(this).attr('data-id');
    $('#UploadIcon').modal('show');
    $('#UploadIcon input[name="activeCategory"]').val(id);
    $('#UploadIcon input[name="activeLanguage"]').val($(this).attr('data-lang'));
});

$('.show-media').click(function () {
    var url = $(this).attr('data-icon-link');
    $('#ShowIcon').modal('show');
    if (url.length > 0) {
        $('#ShowIcon h3').hide();
        $('#ShowIcon img').show();
        $('#ShowIcon img').attr("src", base_url + 'uploads/category_choices_icons/' + url);
    } else {
        $('#ShowIcon img').hide();
        $('#ShowIcon h3').show();
    }
});

$("#UploadIcon form").submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: current_url,
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status == "ok") {
                Command: toastr["success"]("The Icon has been successfully updated ");
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
            else {
                Command: toastr["error"](response.message);
            }
        }
    });
});


/// the Code from Dashboard/Resources
//removeFile 
$(".table").on('click', ".infographics_upload", function (e) {
    Dropzone.forElement('#fileupload').removeAllFiles(); // remove old files from the upload form
    $('#uploadinfographics input[name="AccountId"]').val($(this).attr('data-account-id'));
    $('#files_language').val($(this).attr("data-language"));
});

$(".table").on('click', ".showuploadedFiles", function (e) {
    $('body').addClass('right-bar-enabled');
    $('.delteFiles').removeClass('active');
    $('#files_count').html("");

    $.ajax({
        method: "POST",
        url: base_url + 'index.php/EN/Consultant/getResorceFilesList',
        dataType: 'json',
        data: {
            AccountId: $(this).attr('data-account-id'),
            language: $(this).attr('data-language')
        },
        success: function (data, status, xhr) {
            if (data.length > 0) {
                $('.right-bar .container').html('');
                $('.right-bar h5').html(data[0].Cat_en);
                console.log(data[0].Cat_en);
                var images = ['png', 'jpg', 'jpeg', 'gif'];
                data.forEach(asset => {
                    var newhtml = '<div class="card border shadow-none" data-file-key="' + asset.FileKey + '" >';
                    newhtml += '<input type="checkbox" class="plus-minus"> ';
                    if (images.includes(asset.FileType)) {
                        newhtml += '<img class="card-img-top img-fluid" src="' + base_url + 'uploads/Category_resources/' + asset.file_name + '" alt="sorry this image deleted">';
                    } else {
                        newhtml += '<div class="card-img-top img-fluid file-card"><i class="uil uil-file"></i></div>';
                    }
                    newhtml += '<label class="switch">';
                    newhtml += '<input type="checkbox" class="FileStatus"  ' + (asset.status == "1" ? 'checked' : '') + ' data-file-id="' + asset.FileKey + '">';
                    newhtml += '<span class="slider round"></span>';
                    newhtml += '</label>';
                    newhtml += '<div class="py-2 text-center">';
                    newhtml += '<a href="" class="fw-medium">Download (' + asset.FileType + ')</a>';
                    newhtml += '</div></div>';
                    $('.right-bar .container').append(newhtml);
                });
            } else {
                console.log(data.length);
                $('.right-bar .container').html('<h4> Sorry no Files found here</h4>');
                $('.right-bar h5').html("Recorces list ");
            }
        },
        error: function (xhr, status, error) {
            alert("sorry unexpexted error");
        }
    });
});

$(".table").on('click', ".articles_show", function (e) {
    $.ajax({
        method: "POST",
        url: base_url + 'index.php/EN/Consultant/getCategoriesList',
        dataType: 'json',
        data: {
            accountid: $(this).attr('data-account-id'),
            accounttype: type,
            language: $(this).attr('data-language'),
        },
        success: function (data, status, xhr) {
            var listOfData = data.list;
            if (Object.keys(listOfData).length > 0) {
                $('.ArticlesList').html('');
                listOfData.forEach(article => {
                    var list = '<div class="col-md-6 col-xl-4">';
                    list += '<div class="card" style="border: 1px solid #e0e0e0;">';
                    list += '<label class="switch">';
                    list += '<input type="checkbox" class="ArticleStatus"  ' + (article.status == "1" ? 'checked' : '') + ' data-article-id="' + article.art_id + '">';
                    list += '<span class="slider round"></span>';
                    list += '</label>';
                    list += '<img class="card-img-top img-fluid" src="' + base_url + "uploads/articles_files/" + article.img_url + '" alt="Card image cap">';
                    list += '<div class="card-body">';
                    list += ' <h4 class="card-title mt-0">' + article.title + '</h4>';
                    list += '<p class="card-text">';
                    list += article.art_text.slice(0, 200) + "...Read more";
                    list += '</p>';
                    list += '<button class="btn btn-danger waves-effect waves-light Delet_art mr-1" data-account-id="' + article.art_id + '" ><i class="uil uil-trash-alt font-size-25 text-white mr-1" ></i>Delete</button>';
                    list += '<button class="btn btn-warning waves-effect waves-light Edite_Art" data-article-id="' + article.art_id + '" ><i class="uil uil-pen font-size-25 text-white mr-1"></i>Edite</button>';
                    list += '</div>';
                    list += '</div>';
                    list += '</div>';
                    list += '</div>';
                    $('.ArticlesList').append(list);
                });
            } else {
                $('.ArticlesList').html('<h3 class="text-center w-100"> No Response Found ! </h3>');
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
            $('.ArticlesList').html('<h3 class="text-center w-100"> No Response Found ! </h3>');
        }
    });
});
//
$(".right-bar").on('click', ".plus-minus", function (e) {
    $(this).parent('.card').toggleClass('activated_choice');
    if ($('.activated_choice').length > 0) {
        $('#files_count').html($('.activated_choice').length);
        // show delete icon 
        $('.right-bar .container .card').first().addClass('mt-2');
        $('.delteFiles').addClass('active');
    } else {
        $('#files_count').html("");
        $('.right-bar .container .card').first().removeClass('mt-2');
        $('.delteFiles').removeClass('active');
    }
});


$(".right-bar").on('click', ".delteFiles.active", function (e) {
    var files_array = [];
    $('.right-bar .activated_choice').each(function () {
        files_array.push($(this).attr('data-file-key'));
    });
    console.log(files_array);
    Swal.fire({
        title: "Are you sure?",
        text: "You will delete " + files_array.length + " File(s) ,  You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete it!"
    }).then(function (result) {
        if (result.value) { // start deleting files
            $.ajax({
                method: "DELETE",
                url: base_url + 'index.php/EN/Consultant/getResorceFilesList',
                dataType: 'json',
                data: {
                    files_ids: files_array,
                },
                success: function (data, status, xhr) {
                    if (data.status == "ok") {
                        $('.activated_choice').slideUp();
                        $('.right-bar .container .card').first().removeClass('mt-2');
                        $('.delteFiles').removeClass('active');
                        Swal.fire({
                            title: 'Deleted',
                            text: files_array.length + " File(s) , Has been deleted",
                            icon: 'success',
                            confirmButtonColor: '#5b73e8',
                        });
                        $('body').removeClass('right-bar-enabled');
                    }
                }
            });
        }
    });
});

// Add restrictions
Dropzone.options.fileupload = {
    acceptedFiles: 'image/*,application/pdf,.psd',
    maxFilesize: 50, // MB ,
};


// setting the category id 
$(".table").on('click', ".article_upload", function (e) {
    $('.tox-statusbar__branding').remove();
    $("#Articles input[name='accountid']").val($(this).attr('data-account-id'));
    $("#Articles input[name='articles_language']").val($(this).attr('data-language'));
});

/*
 * btn name : article_upload
 */
$("#add_article").on('submit', function (e) {
    e.preventDefault();
    $('#add_article .btn[type="Submit"]').attr('disabled', "disabled");
    $('#add_article .btn[type="Submit"]').html('Please wait ...');
    setTimeout(() => { // this timeout is for generating the article
        $.ajax({
            type: 'POST',
            url: base_url + 'index.php/EN/Consultant/articles_controle',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('#add_article .btn[type="Submit"]').removeAttr('disabled');
                $('#add_article .btn[type="Submit"]').html('Save');
                if (data.status == "ok") {
                    Swal.fire({
                        title: 'Added !',
                        text: 'The Article Added successfully .',
                        icon: 'success'
                    });
                    $('#Articles').modal('hide');
                } else {
                    Swal.fire({
                        title: 'Sorry !',
                        text: 'We have an error in processing this request',
                        icon: 'error',
                        footer: "Please try again later"
                    });
                }
            },
            ajaxError: function () {
                Swal.fire({
                    title: 'Sorry !',
                    text: 'We have an error in processing this request',
                    icon: 'error',
                    footer: "Please try again later"
                });
            }
        });
    }, 500);
});

// ClassicEditor
//     .create(document.querySelector('#classic-editor'), {
//         ckfinder: {
//             uploadUrl: base_url + 'index.php/EN/Consultant/upload_for_articles'
//         }
//     })
//     .then()
//     .catch(error => {
//         console.error(error);
//     });

function readURL(input) {
    if (input.files && input.files[0]) {
        $('.file-upload-btn').html(' The file has been selected');
    } else {
        $('.file-upload-btn').html(' Add Image ');
    }
}

$("#Articles_show").on('click', ".Delet_art", function (e) {
    var account = $(this).attr('data-account-id');
    var thediv = this;
    console.log($(this).parents().parents().parents().parents().html());
    Swal.fire({
        title: "Are you sure ? ",
        text: "You won't be able to revert this !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: "Yes, delete it!"
    }).then(function (result) {
        if (result.value) { // start deleting files
            $.ajax({
                method: "DELETE",
                url: base_url + 'index.php/EN/Consultant/getCategoriesList',
                data: {
                    key: account,
                    accounttype: type,
                },
                success: function (data, status, xhr) {
                    if (data.status == "ok") {
                        console.log($(thediv).parents().parents().parents().parents().html());
                        $(thediv).parents().parents().parents(".col-md-6").slideUp();
                        Swal.fire({
                            title: 'Deleted',
                            text: " Articles , Has been deleted Successfully",
                            icon: 'success',
                            confirmButtonColor: '#5b73e8',
                        });
                        setTimeout(() => {
                            $(thediv).parents().parents().parents(".col-md-6").remove();
                        }, 800);
                    } else {
                        Swal.fire({
                            title: 'Error !',
                            text: "Sorry We can't delete this article",
                            icon: 'error',
                            confirmButtonColor: '#5b73e8',
                        });
                    }
                }
            });
        }
    });
});


$("#Articles_show").on('click', ".Edite_Art", function (e) {
    var id = $(this).attr('data-article-id');
    location.href = base_url + "index.php/EN/Consultant/article/" + id;
});


// new editore

$(document).ready(function () {

    if ($("#elm1").length > 0) {
        tinymce.init({
            selector: "textarea#elm1",
            file_picker_types: 'file image media',
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            style_formats: [{
                title: 'Bold text',
                inline: 'b'
            },
            {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }
            },
            {
                title: 'Red header',
                block: 'h1',
                styles: {
                    color: '#ff0000'
                }
            },
            {
                title: 'Example 1',
                inline: 'span',
                classes: 'example1'
            },
            {
                title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            },
            {
                title: 'Table styles'
            },
            {
                title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }
            ]
        });
    }

});

// Prevent Bootstrap dialog from blocking focusin
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-tinymce, .tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});


$('.right-bar .container').on('change', '.FileStatus', function () {
    var fileId = $(this).attr('data-file-id');
    $.ajax({
        type: "PUT",
        url: base_url + "index.php/EN/Consultant/getResorceFilesList",
        data: {
            id: fileId
        },
        success: function (response) {
            if (response == "error") {
                alert('Sorry we have an error , please try again later');
            }
        }
    });
});

$('.ArticlesList').on('change', '.ArticleStatus', function () {
    var fileId = $(this).attr('data-article-id');
    $.ajax({
        type: "PUT",
        url: base_url + "index.php/EN/Consultant/getCategoriesList",
        data: {
            id: fileId
        },
        success: function (response) {
            if (response == "error") {
                alert('Sorry we have an error , please try again later');
            }
        }
    });
});