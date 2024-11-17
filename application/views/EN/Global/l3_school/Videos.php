<div class="main-content">
    <div class="page-content">
	<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">MY MEDIA</h4>
        <div class="row">
            <?php foreach ($videos as $video) { ?>
                <?php
                $linkparts = explode("?", trim($video['link']));
                if (sizeof($linkparts) == 2) {
                    $videoid = str_replace("v=", "", $linkparts[1]);
                } else {
                    $videoid = "notfound";
                }
                ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card"><img class="card-img-top img-fluid" src="https://img.youtube.com/vi/<?= $videoid ?>/0.jpg">
                        <div class="card-body">
                            <p data-link-id="11"><?= $video['title'] ?></p>
                            <a href="<?= $video['link'] ?>" target="_blank" class="btn btn-primary waves-effect waves-light w-100 mt-1">Watch the video</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>