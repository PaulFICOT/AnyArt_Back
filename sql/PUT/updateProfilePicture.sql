SELECT pictures.picture_id FROM picture AS pictures
WHERE pictures.user_id = 2 AND pictures.post_id IS NULL;

UPDATE picture AS pictures
SET pictures.url = 'jpq664wh2'
WHERE pictures.picture_id = 2