SELECT
     posts.post_id
    ,posts.title
    ,posts.content AS 'description'
    ,pictures.url AS 'url_pic'
    ,views.view_count
    ,(SELECT like_id FROM posts_like likes
        WHERE likes.post_id = posts.post_id AND likes.is_like = true) AS 'likes'
    ,(SELECT like_id FROM posts_like dislikes
        WHERE dislikes.post_id = posts.post_id AND dislikes.is_like = false) AS 'dislikes'
    ,tags.tag

FROM posts

INNER JOIN picture pictures ON posts.post_id = pictures.post_id
INNER JOIN posts_view views ON posts.post_id = views.post_id
INNER JOIN posts_category_list cat_list ON posts.post_id = cat_list.post_id
INNER JOIN posts_tag tags ON posts.post_id = tags.post_id

