SELECT
     posts.post_id
    ,posts.title
    ,posts.user_id
    ,users.username
    ,users.is_verified
    ,users.job_function
    ,users.open_to_work
    ,(SELECT picture.picture_id FROM picture
        WHERE picture.user_id = users1.user_id AND picture.post_id IS NULL) 'picture_id'
    ,(SELECT picture.url FROM picture
        WHERE picture.user_id = users1.user_id AND picture.post_id IS NULL) 'url'
    ,posts.content
    ,views.view_count
    ,(SELECT COUNT(like_id) FROM posts_like isliked
    WHERE isliked.user_id = :currentUser AND isliked.post_id = posts.post_id AND isliked.is_like = TRUE) AS 'isLiked'
    ,(SELECT COUNT(like_id) FROM posts_like isdisliked
    WHERE isdisliked.user_id = :currentUser AND isdisliked.post_id = posts.post_id AND isdisliked.is_like = FALSE) AS 'isDisliked'
    ,(SELECT COUNT(like_id) FROM posts_like likes
        WHERE likes.post_id = posts.post_id AND likes.is_like = TRUE) AS 'likes'
    ,(SELECT COUNT(like_id) FROM posts_like dislikes
        WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = FALSE) AS 'dislikes'

FROM posts

INNER JOIN users ON (posts.user_id = users.user_id)
INNER JOIN posts_view views ON (posts.post_id = views.post_id)

WHERE posts.post_id = 1