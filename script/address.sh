#!/bin/bash
cat address.sql \
INSERT_Countryes.sql \
INSERT_Regions.sql \
INSERT_Districts.sql \
INSERT_Localities.sql \
INSERT_Streets.sql \
INSERT_Humans.sql  \
INSERT_Phones.sql \
INSERT_Human_Phone.sql \
| mysql -u root -p
