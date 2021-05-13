SET @user = 2;
SET @tags = (SELECT GROUP_CONCAT(DISTINCT pt.tag  SEPARATOR  ' ') FROM users u
INNER JOIN posts_like pl on u.user_id = pl.user_id
INNER JOIN posts_tag pt on pl.post_id = pt.post_id
WHERE u.user_id = @user
GROUP BY u.username );
SET @categories = (SELECT GROUP_CONCAT(DISTINCT c.category SEPARATOR ' ') FROM users u
INNER JOIN posts_like pl on u.user_id = pl.user_id
INNER JOIN posts_category_list pcl on pl.post_id = pcl.post_id
INNER JOIN categories c on pcl.category_id = c.category_id
WHERE u.user_id = @user
GROUP BY u.username);
SET @keywords = @tags + @categories;
SET @rowCount = (SELECT COUNT(post_id) FROM posts);

PREPARE BEST_POSTS FROM '
SELECT
     u.username
    ,p.post_id
    ,MATCH(u.username, u.job_function) AGAINST(@keywords)
      +
     MATCH(p.title, p.content) AGAINST (@keywords)
      +
     MATCH(c.category) AGAINST(@keywords)
      +
     MATCH(pt.tag) AGAINST(@keywords)
      +
     MATCH(c2.country) AGAINST(@keywords) AS TEST
FROM users u

INNER JOIN posts p on u.user_id = p.user_id
INNER JOIN posts_category_list pcl on p.post_id = pcl.post_id
INNER JOIN categories c on pcl.category_id = c.category_id
INNER JOIN posts_tag pt on p.post_id = pt.post_id
INNER JOIN countries c2 on u.country_id = c2.country_id

WHERE u.user_id <> @user

ORDER BY TEST DESC LIMIT ?;
';

EXECUTE BEST_POSTS USING @rowCount