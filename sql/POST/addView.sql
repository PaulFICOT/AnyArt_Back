UPDATE posts_view pv
SET pv.view_count = pv.view_count +1
WHERE pv.post_id = :post