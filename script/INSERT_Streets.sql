USE 'address';
SET NAMES 'utf8';

INSERT INTO Streets (locality_id,street)
VALUES
(1,'ул. Советсткая'),
(1,'пр. Ленина'),
(1,'ул. Садовая'),
(1,'ул. Чигрина'),
(1,'пр. Октябрьский'),
(1,'ул. Космонавтов'),
(1,'ул. Колодезная'),
(1,'ул. Радужная'),
(1,'ул. Чайковского');

insert into Houses (street_id , house) values
(9,'29/1');

