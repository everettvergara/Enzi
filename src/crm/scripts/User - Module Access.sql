declare @user_code as varchar(100),
		@module_id as bigint 

set @user_code = 'charles'
set @module_id = 10


/* Basic Keys */ 
select	d.element_key,
		'N' as batch 

from	sys_user as a 
		inner join sys_user_element as b on 
		a.user_id  = b.user_id 

		inner join sys_mod as c on
		b.module_id = c.module_id
		
		inner join sys_mod_element as d on
		b.element_id = d.element_id 
where	a.user_code = @user_code and 
		c.module_id = @module_id and 
		a.user_id <> 1 

/* Batch Functions */
/*union all 
select	d.element_key,
		'Y' as batch 

from	sys_user as a 
		inner join sys_user_element as b on 
		a.user_id  = b.user_id 

		inner join sys_mod as c on
		b.module_id = c.module_id
		
		inner join sys_mod_element as d on
		b.element_id = d.element_id 
where	a.user_code = @user_code and 
		c.module_id = @module_id and 
		a.user_id <> 1 
*/