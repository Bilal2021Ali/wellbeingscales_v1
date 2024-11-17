<style>
    .chat-conversation-message {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /*  ar version overrides */
    .chat-conversation .left .conversation-list {
        float: left;
        text-align: left;
    }

    .chat-conversation .conversation-list .ctext-wrap-content:before {
        content: "";
        position: absolute;
        border: 5px solid transparent;
        border-left-color: rgba(91, 115, 232, 0.1);
        border-top-color: rgba(91, 115, 232, 0.1);
        right: -10px !important;
        top: 0;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <div class="w-100 user-chat mt-4 mt-sm-0 ms-lg-1">
            <div class="card">
                <div>
                    <div class="chat-conversation py-3">
                        <ul class="list-unstyled mb-0 chat-conversation-message px-3">
                            <li class="chat-day-title loading-old-messsages" style="display: none">
                                <div class="title">Loading Old Messages</div>
                            </li>
                            <!-- Chat -->
                        </ul>
                    </div>
                </div>
                <div class="p-3 chat-input-section">
                    <form class="row">
                        <div class="col">
                            <div class="position-relative">
                                <input type="text" class="form-control chat-input rounded" placeholder="اكتب رسالة ...">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary chat-send w-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">إرسال</span> <i class="mdi mdi-send float-end"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script>
    var lastmessage = null;
    var sendDefault = '<span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send float-end"></i>';
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 300,
            "timeOut": 5000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        fetchmessages();
        // fetchmessages every 10 seconds
        setInterval(() => {
            var lastKey = $('.chat-message').last().attr('data-key') || null;
            fetchmessages(lastKey);
        }, 5000);
    });

    function fetchmessages(lastId = null, old = false) {
        var today = new Date();
        today = (("0" + (today.getMonth() + 1)).slice(-2)) + "-" + today.getDate() + "-" + today.getFullYear(); // returns the date
        console.log(today);
        $.ajax({
            type: "GET",
            url: "<?= base_url("EN/ajax/chat/" . $fileid); ?>",
            data: {
                lastId: lastId,
                older: old
            },
            success: function(response) {
                if (response.status == "ok") {
                    // show the messages
                    Object.entries(response.messages).forEach((key, messages) => {
                        if (key[0] !== "") {
                            var chatdate = (key[0] == today ? "اليوم" : key[0]) || "--/--/----";
                            $('.chat-conversation-message').append(`<li class="chat-day-title">
                                <div class="title">${chatdate}</div>
                            </li>`);
                        }
                        key[1].forEach(message => {
                            if (message.sender_id == "<?= $sessiondata['admin_id'] ?>" && message.sender_usertype == '<?= $sessiondata['type'] ?>') {
                                darwmessage(message, "sent", old);
                            } else {
                                darwmessage(message, "recieved", old);
                            }
                        });
                    });
                }
            }
        });
    }
    const darwmessage = (data, type, old = false) => {
        <?php /* type could be 'recieved' or 'sent' */ ?>
        var t = data.TimeStamp.split(/[- :]/); // Split timestamp into [ Y, M, D, h, m, s ]
        var d = new Date(Date.UTC(t[0], t[1] - 1, t[2], t[3], t[4], t[5])); // Apply each element to the Date function
        const messagetime = d.getHours() + ":" + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes(); //
        const template = `<li class="${type == "sent" && "left"} chat-message animate__animated ${type == "sent" ? "animate__bounceInRight" : "animate__bounceInLeft"}" data-key="${data.Id}">
            <div class="conversation-list">
                <div class="ctext-wrap">
                    <div class="ctext-wrap-content">
                        <h5 class="font-size-14 conversation-name text-dark">${type == "sent" ? "أنت" : "<?= $sessiondata['type'] == "consultant" ? $targetedAccount["Name"] : "المستشار" ?>"}
                        <span class="d-inline-block font-size-12 text-muted ms-2">${messagetime}</span></h5>
                        <p class="mb-0">${data.message_content}</p>
                    </div>
                </div>
            </div>
        </li>`;
        if (old) {
            $('.chat-conversation-message').prepend(template);
            // $(".chat-conversation").scrollTop(50);
        } else {
            $('.chat-conversation-message').append(template);
            $(".chat-conversation-message").scrollTop($(".chat-conversation")[0].scrollHeight);
        }
    }

    /// send a message
    $('form.row').on('submit', (e) => {
        e.preventDefault();
        const message = $('.chat-input').val();
        if (message.length > 0) {
            // sendmessage(message);
            $('.chat-send').attr('disabled', 'disabled');
            $('.chat-send').html('Sending...');
            $.ajax({
                type: "POST",
                url: "<?= base_url("EN/ajax/chat/" . $fileid); ?>",
                data: {
                    message: message,
                    targetKey: "<?= $sessiondata['type'] == 'consultant' ? $targetedAccount['Id'] : $target ?>",
                    target: "<?= $sessiondata['type'] == 'consultant' ? $targetedAccount['Type'] : "consultant" ?>",
                },
                success: function(response) {
                    $('.chat-send').removeAttr('disabled');
                    $('.chat-send').html(sendDefault);
                    if (response.status == "ok") {
                        $('.chat-input').val("");
                        var lastKey = $('.chat-message').last().attr('data-key') || null;
                        fetchmessages(lastKey);
                        // darwmessage(response.message, "sent");

                    } else {
                        Command: toastr["error"](response.message);
                    }
                }
            });
        } else {
            Command: toastr["error"]("You have to enter a message first !", "Sorry !")
        }
    });

    $(function() {
        $(".chat-conversation-message").scroll(function() {
            if ($(".chat-conversation-message").scrollTop() === 0) { // load older messages
                var old = $('.chat-message').first().offset().top + 50;
                $('.loading-old-messsages').show();
                var FirstKey = $('.chat-message').first().attr('data-key') || null;
                fetchmessages(FirstKey, true);
                $('.loading-old-messsages').hide();
                $('.chat-conversation-message').animate({
                    scrollTop: old,
                }, 1000);
            }
        });
    });
</script>