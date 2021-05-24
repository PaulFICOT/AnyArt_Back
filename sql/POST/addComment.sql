INSERT INTO posts_comment(content, crea_date, reply_to, user_id, post_id)
VALUE (
         ?
        ,?
        ,? #null when not a reply | comment_id when reply
        ,?
        ,?
    )