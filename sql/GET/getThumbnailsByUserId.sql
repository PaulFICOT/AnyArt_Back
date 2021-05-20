SELECT
                 posts.post_id
                ,pictures.url
            FROM posts

            INNER JOIN picture AS pictures ON (posts.post_id = pictures.post_id)

            WHERE pictures.is_thumbnail = '1' AND posts.user_id = 2