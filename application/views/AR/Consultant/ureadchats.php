<div class="main-content">
    <div class="page-content">
        <div class="chat-message-list card">
            <div class="card-body">
                <h3 class="card-title mb-3">رسائل غير مقروءة :</h3>
                <?php if (!empty($chats)) { ?>
                    <ul class="list-unstyled chat-list">
                        <?php foreach ($chats as $chat) { ?>
                            <li class="unread">
                                <a href="<?= base_url("EN/Consultant/chat/") . $chat['Report_Id']; ?>">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3 align-self-center mr-2">
                                            <div class="user-img">
                                                <div class="avatar-xs align-self-center">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        <?= strtoupper(substr($chat['U_Name'], 0, 1)) ?? "U" ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-truncate font-size-14 mb-1"><?= $chat['U_Name'] ?></h5>
                                            <p class="text-truncate mb-0">رد على <span class="text-primary link" data-link="<?= $chat['link'] ?>">هذا التقرير</span></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div class="font-size-11"><?= $keys[strtoupper($chat['AccountType'])]; ?></div>
                                            <div class="unread-message">
                                                <span class="badge bg-danger rounded-pill p-1 text-white">0<?= $chat['unreadCounter'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php }else{ ?>
                    <div class="container text-center mt-5">
                        <img src="<?= base_url("assets/images/new-messages.svg") ?>" class="img-responsive" style="max-width: 200px"/>
                        <h3 class="text-primary mt-4">لا توجد رسائل هنا للعرض!</h3>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('.chat-list .link').click(function() {
        window.open($(this).attr('data-link'));
    });
</script>