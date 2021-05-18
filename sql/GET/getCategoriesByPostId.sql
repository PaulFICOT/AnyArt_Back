SELECT
     posts.post_id
    ,categories.category_id
    ,categories.category

FROM posts

INNER JOIN posts_category_list ON (posts.post_id = posts_category_list.post_id)
INNER JOIN categories ON (posts_category_list.category_id = categories.category_id)

WHERE posts.post_id = 2