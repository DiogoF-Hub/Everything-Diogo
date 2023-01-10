use chat;

INSERT INTO messages(UserId,MsgText) VALUE((SELECT UserId from users where UserName="Dan"),"testInsert");