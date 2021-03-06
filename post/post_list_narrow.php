<?php
//_debug($posts);
$block = pagination_block($posts);

if (isset($block[0])) :
    foreach ($block[$_SESSION[$i]] as $post) :
        $user = new User($post['user_id']);
        $post_user = $user->get_user();
?>
<div class="post narrow">
    <a href="../post/post_disp.php?post_id=<?= $post['id'] ?>&user_id=<?= $current_user['id'] ?>" class="post_link">
        <div class="post_list">
            <div class="post_user">
                <object><a
                        href="../user/user_disp.php?user_id=<?= $current_user['id'] ?>&page_id=<?= $post_user['id'] ?>&type=main">
                        <img src="/user/image/<?= $post_user['image'] ?>">
                        <?php print '' . $post_user['name'] . ''; ?>
                    </a></object>
            </div>
            <div class="post_text ellipsis" id="post_text"><?php print '' . $post['text'] . ''; ?></div>
            <?php if (substr_count($post['text'], "\n") + 1 > 10) : ?>
            <object><a href="#" class="show_all">続きを表示する</a></object>
            <?php endif;
                    if (!empty($post['image'])) :
                        print '<img src="/post/image/' . $post['image'] . '" class="post_img" >';
                    endif;
                    ?>
    </a>
    <div class="post_info">
        <form class="favorite_count" action="#" method="post">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <button type="button" name="favorite" class="btn favorite_btn" data-toggle="favorite" title="いいね">
                <?php if (!check_favolite_duplicate($_SESSION['user_id'], $post['id'])) : ?>
                <i class="far fa-star"></i>
                <?php else : ?>
                <i class="fas fa-star"></i>
                <?php endif; ?>
            </button>
            <?php
                    $post_class = new Post($post['id']);
                    $post = $post_class->get_post();
                    ?>
            <span class="post_count"><?= current($post_class->get_post_favorite_count()) ?></span>
        </form>
        <div class="post_favorite">
            <button class="btn modal_btn" data-target="#modal<?= $post['id'] ?>_narrow" type="button" data-toggle="post"
                title="投稿"><i class="fas fa-comment-dots"></i></button>
            <span class="post_comment_count"><?= current($post_class->get_post_favorite_count()) ?></span>
        </div>
        <div class="comment_confirmation" id="modal<?= $post['id'] ?>_narrow">
            <p class="modal_title">この投稿にコメントしますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form method="post" action="../comment/comment_add_done.php" enctype="multipart/form-data">
                <textarea id="comment_counter_narrow" class="textarea form-control" placeholder="コメントを入力ください"
                    name="text"></textarea>
                <div class="counter">
                    <span class="comment_count">0</span><span>/300</span>
                </div>
                <div class="comment_img">
                    <label>
                        <i class="far fa-image"></i>
                        <input type="file" name="image_name" id="comment_image_narrow" accept="image/*" multiple>
                    </label>
                    <p><img class="comment_preview"></p>
                    <i class="far fa-times-circle comment_clear"></i>
                </div>
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <div class="post_btn">
                    <button class="btn btn-outline-danger" type="submit" name="comment" value="comment">コメント</button>
                    <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                </div>
            </form>
        </div>
        <?php if ($post['user_id'] == $current_user['id']) : ?>
        <button class="btn modal_btn" data-target="#edit_modal<?= $post['id'] ?>_narrow" type="button"
            data-toggle="edit" title="編集"><i class="fas fa-edit"></i></button>
        <div class="post_edit" id="edit_modal<?= $post['id'] ?>_narrow">
            <p>投稿内容更新</p>
            <form method="post" action="../post/post_edit_done.php" enctype="multipart/form-data">
                <textarea id="edit_counter_narrow" class="textarea form-control" placeholder="投稿内容を編集してください"
                    name="text"><?php print $post['text']; ?></textarea>
                <div class="counter">
                    <span class="post_edit_count">0</span><span>/300</span>
                </div>
                <div class="post_image">
                    <label>
                        <i class="far fa-image"></i>
                        <input type="file" name="image_name" id="edit_image_narrow" accept="image/*" multiple>
                    </label>
                    <p><img class="edit_preview"></p>
                    <i class="far fa-times-circle edit_clear"></i>
                </div>
                <input type="hidden" name="id" value="<?php print $post['id']; ?>">
                <input type="hidden" name="image_name_old" value="<?php print $post['image']; ?>">
                <div class="post_btn">
                    <button class="btn btn-outline-danger" type="submit" name="edit" value="edit">更新</button>
                    <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
                </div>
            </form>
        </div>
        <button class="btn modal_btn" data-target="#delete_modal<?= $post['id'] ?>_narrow" type="button"
            data-toggle="delete" title="削除"><i class="far fa-trash-alt"></i></button>
        <div class="delete_confirmation" id="delete_modal<?= $post['id'] ?>_narrow">
            <p class="modal_title">こちらの投稿を削除しますか？</p>
            <p class="post_content"><?= nl2br($post['text']) ?></p>
            <form action="../post/post_delete_done.php" method="post">
                <input type="hidden" name="id" value="<?= $post['id'] ?>">
                <input type="hidden" name="image_name" value="<?= $post['image'] ?>">
                <button class="btn btn-outline-danger" type="submit" name="delete" value="delete">削除</button>
                <button class="btn btn-outline-primary modal_close" type="button">キャンセル</button>
            </form>
        </div>
        <?php endif; ?>
    </div>
    <p class="post_created_at"><?php print '' . convert_to_fuzzy_time($post['created_at']) . ''; ?></p>
</div>
</div>
<?php endforeach ?>
<?php endif ?>
<?php require('../pagination.php'); ?>