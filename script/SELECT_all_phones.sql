select f,i,o,phone,note from Humans,Phones,Human_Phone 
where 
Human_Phone.human_id=Humans.id AND 
Human_Phone.phone_id=Phones.id;
