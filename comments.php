<?php
/**
 * The template for displaying comments
 */

if (!defined('ABSPATH')) { exit; }

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <div class="container">
        <div class="section">
            <?php if (have_comments()) : ?>
                <h2 class="comments-title">
                    <?php
                    $comment_count = get_comments_number();
                    if ('1' === $comment_count) {
                        printf(
                            /* translators: 1: title. */
                            esc_html__('One thought on &ldquo;%1$s&rdquo;', 'furscoopers'),
                            '<span>' . wp_kses_post(get_the_title()) . '</span>'
                        );
                    } else {
                        printf(
                            /* translators: 1: comment count number, 2: title. */
                            esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'furscoopers')),
                            number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            '<span>' . wp_kses_post(get_the_title()) . '</span>'
                        );
                    }
                    ?>
                </h2>

                <?php the_comments_navigation(); ?>

                <ol class="comment-list">
                    <?php
                    wp_list_comments(
                        array(
                            'style'       => 'ol',
                            'short_ping'  => true,
                            'avatar_size' => 60,
                            'callback'    => 'furscoopers_comment',
                        )
                    );
                    ?>
                </ol>

                <?php the_comments_navigation(); ?>

                <?php if (!comments_open()) : ?>
                    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'furscoopers'); ?></p>
                <?php endif; ?>

            <?php endif; ?>

            <?php
            $commenter = wp_get_current_commenter();
            $comment_form_args = array(
                'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
                'title_reply_after'  => '</h3>',
                'class_form'         => 'comment-form',
                'comment_field'      => '<p class="comment-form-comment">
                    <label for="comment">' . esc_html_x('Comment', 'noun', 'furscoopers') . ' <span class="required">*</span></label>
                    <textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . esc_attr__('Write your comment here...', 'furscoopers') . '"></textarea>
                </p>',
                'fields'             => array(
                    'author' => '<p class="comment-form-author">
                        <label for="author">' . esc_html__('Name', 'furscoopers') . ' <span class="required">*</span></label>
                        <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" autocomplete="name" required="required" />
                    </p>',
                    'email'  => '<p class="comment-form-email">
                        <label for="email">' . esc_html__('Email', 'furscoopers') . ' <span class="required">*</span></label>
                        <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" autocomplete="email" required="required" />
                    </p>',
                    'url'    => '<p class="comment-form-url">
                        <label for="url">' . esc_html__('Website', 'furscoopers') . '</label>
                        <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" autocomplete="url" />
                    </p>',
                ),
                'label_submit'       => esc_html__('Post Comment', 'furscoopers'),
                'submit_button'      => '<input name="%1$s" type="submit" id="%2$s" class="%3$s cta-button" value="%4$s" />',
                'class_submit'       => 'submit',
                'format'             => 'xhtml',
            );

            comment_form($comment_form_args);
            ?>
        </div>
    </div>
</div>

<?php
/**
 * Custom comment callback function
 */
function furscoopers_comment($comment, $args, $depth) {
    if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('pingback'); ?>>
        <div class="comment-body">
            <?php esc_html_e('Pingback:', 'furscoopers'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(esc_html__('Edit', 'furscoopers'), '<span class="edit-link">', '</span>'); ?>
        </div>

    <?php else : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?>>
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                    <b class="fn"><?php comment_author_link(); ?></b> <span class="says"><?php esc_html_e('says:', 'furscoopers'); ?></span>
                </div>

                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php
                            /* translators: 1: comment date, 2: comment time */
                            printf(esc_html__('%1$s at %2$s', 'furscoopers'), get_comment_date('', $comment), get_comment_time());
                            ?>
                        </time>
                    </a>
                    <?php edit_comment_link(esc_html__('Edit', 'furscoopers'), '<span class="edit-link">', '</span>'); ?>
                </div>

                <?php if ('0' == $comment->comment_approved) : ?>
                <p class="comment-awaiting-moderation"><?php esc_html_e('Your comment is awaiting moderation.', 'furscoopers'); ?></p>
                <?php endif; ?>
            </footer>

            <div class="comment-content">
                <?php comment_text(); ?>
            </div>

            <?php
            $reply_args = array(
                'add_below' => 'div-comment',
                'depth'     => $depth,
                'max_depth' => $args['max_depth']
            );
            comment_reply_link(array_merge($args, $reply_args));
            ?>
        </article>

    <?php endif;
}
?>