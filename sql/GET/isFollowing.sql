SELECT
    COUNT(follower_id)
FROM users_follower

WHERE follower_user_id = :follower
  AND followed_user_id = :followed