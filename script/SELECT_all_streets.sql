select locality,Streets.id,street.id from  Countries,Regions,Districts,Localities,Streets 
where 
Countries.id=Regions.country_id AND 
Regions.id=Districts.region_id AND 
Districts.id=Localities.district_id AND 
Localities.id=Streets.locality_id;
