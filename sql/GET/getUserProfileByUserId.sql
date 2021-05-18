SELECT
     users1.user_id
    ,users1.username
    ,users1.is_verified
    ,users1.is_active
    ,users1.is_banned
    ,users1.profile_desc
    ,users1.job_function
    ,users1.open_to_work
    ,pictures.url AS 'profile_pic'
    ,(SELECT COUNT(followed_user_id) FROM users_follower AS users_follower2
        WHERE users_follower2.followed_user_id = users1.user_id) AS 'Followers'
    ,(SELECT SUM(posts_view2.view_count) FROM posts AS posts2
        INNER JOIN posts_view AS posts_view2 ON (posts2.post_id = posts_view2.post_id)
        WHERE posts2.user_id = 2) AS 'Views'
    ,(SELECT COUNT(posts_like3.like_id) FROM posts AS posts3
        INNER JOIN posts_like AS posts_like3 ON (posts3.post_id = posts_like3.post_id)
        WHERE posts3.user_id = 2 AND posts_like3.is_like = TRUE) AS 'Likes'
FROM users users1

INNER JOIN picture AS pictures ON (users1.user_id = pictures.user_id AND pictures.is_thumbnail = TRUE)

WHERE users1.user_id = 2