UPDATE picture p
SET p.url = 'testTEST'
#, p.post_id = ?, p.user_id = ? #Add/change the column you want to update
WHERE p.picture_id = 10