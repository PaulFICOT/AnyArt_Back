SET @page = 1;
SET @maxview = 1500;
SET @limit = 20;
SET @offset = (@page-1) * @limit;

SET @user = 2;
SET @keywords = (SELECT
         CONCAT_WS(' ', GROUP_CONCAT(DISTINCT c.category SEPARATOR ' '),
         GROUP_CONCAT(DISTINCT pt.tag  SEPARATOR  ' ')) FROM users u
INNER JOIN posts_like pl on u.user_id = pl.user_id
INNER JOIN posts_category_list pcl on pl.post_id = pcl.post_id
INNER JOIN categories c on pcl.category_id = c.category_id
INNER JOIN posts_tag pt on pl.post_id = pt.post_id
WHERE u.user_id = @user
GROUP BY u.username);

PREPARE BEST_POSTS FROM '
SELECT
     p.post_id
    ,u.username
    ,p.title
    ,p2.picture_id
    ,p2.url
    ,(SELECT MAX(MATCH(u2.username, u2.job_function) AGAINST(@keywords) +
        MATCH(p3.title, p3.content) AGAINST (@keywords) +
        MATCH(c.category) AGAINST(@keywords) +
        MATCH(pt.tag) AGAINST(@keywords) +
        MATCH(c2.country) AGAINST(@keywords))
      FROM users u2
      INNER JOIN posts p3 on u2.user_id = p3.user_id
      INNER JOIN posts_category_list pcl on p3.post_id = pcl.post_id
      INNER JOIN categories c on pcl.category_id = c.category_id
      INNER JOIN posts_tag pt on p3.post_id = pt.post_id
      INNER JOIN countries c2 on u2.country_id = c2.country_id
      WHERE p.post_id = p3.post_id ) AS RELEVANCE
FROM users u

INNER JOIN posts p ON (u.user_id = p.user_id)
INNER JOIN picture p2 ON (p.post_id = p2.post_id AND p2.is_thumbnail = TRUE)
INNER JOIN posts_view pv ON (p.post_id = pv.post_id)

WHERE u.user_id <> @user AND pv.view_count < ?

ORDER BY RELEVANCE DESC LIMIT ? OFFSET ?;
';

EXECUTE BEST_POSTS USING @maxview, @limit, @offset