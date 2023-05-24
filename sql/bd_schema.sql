create schema if not exists company;

use company;

# Employees table
create table if not exists company.employees (
	# Employees Attributes
	emp_id int auto_increment,
	mail varchar(75) not null,
	passwd varchar(150) not null,
	perms varchar(20) default 'staff',
	# Constraints
	constraint ID_EMP_PK primary key (emp_id),
	constraint UQ_MAIL unique(mail)
);

# Categories table
create table if not exists company.categories (
	# Categories Attributes
	cat_id int auto_increment,
	name varchar(25) not null,
	# Constraints
	constraint ID_CAT_PK primary key (cat_id)
);

# Fees table
create table if not exists company.fees (
	# Fees Attributes
	fee_id int auto_increment,
	name varchar(25) not null,
		# I will set the profit as a percentage
	profit int(2) not null,
	# Constraints
	constraint ID_FEE_PK primary key (fee_id)
);

# Products table
create table if not exists company.products (
	# Products Attributes
	prd_id int auto_increment,
	name varchar(75) not null,
	description varchar(250),
	iva int(2) not null,
	stock int default 0,
	cat_id int,
	fee_id int,
	# Constraints
	constraint ID_PK_PRD primary key (prd_id),
	constraint ID_CAT_FK foreign key (cat_id) references company.categories(cat_id)
		on delete set null on update cascade,
	constraint ID_FEE_FK foreign key (fee_id) references company.fees(fee_id)
		on delete set null on update cascade
);

# Providers table
create table if not exists company.providers (
	# Providers Attributes
	prv_id int auto_increment,
	nif varchar(9) not null,
	name varchar(75) not null,
	direction varchar(150) not null,
	locality varchar(100) not null,
	cp int(5) not null,
	telephone int(9) not null,
	mail varchar(150),
	status boolean default true,
	# Constraints
	constraint ID_PK_PRV primary key (prv_id),
	constraint UQ_PRV_NIF unique (nif)
);

# Products providers table
create table if not exists company.prd_providers (
	# Products providers Attributes
	prd_id int,
	prv_id int,
	prod_cost decimal (4,2) not null,
		# PVP calculated: pvp = prd_cost*(1+fee). Fee will be taken by subquery and then pvp will be calculated
		# Because of this reason, this value is nullable
	pvp decimal (4,2),
	# Constraints
	constraint ID_PRD_PRV_PK primary key (prd_id,prv_id),
	constraint ID_PRD_FK foreign key (prd_id) references company.products(prd_id)
		on delete cascade on update cascade,
	constraint ID_PRV_FK foreign key (prv_id) references company.providers(prv_id)
		on delete cascade on update cascade
);

# Clients table
create table if not exists company.clients (
	# Clients Attributes
	cli_id int auto_increment,
	nif varchar(9) not null,
	complete_name varchar(150) not null,
		# Since there can be cash customers, these fields need to be nullable. There will be a NIF for this client type
	direction varchar(150),
	locality varchar(100),
	cp int(9),
	telephone varchar(14),
	mail varchar(150),
	# Constraints
	constraint ID_CLI_PK primary key (cli_id),
	constraint UQ_CLI_NIF unique (nif)
);

# Receipts table
create table if not exists company.receipts (
	# Receipts Attributes
	rcp_id int auto_increment,
	rcp_date date not null,
		# Not a FK because info must remain if a client is deleted from the DB
	cli_id int,
	# Constraints
		# Since info must not be deleted in this table, there are no FK, but info will be provided from other tables
	constraint ID_RCP_PK primary key (rcp_id)
);

# Receipts lines table
create table if not exists company.receipts_lines (
	# Lines Attributes
		#! All this info is taken from other tables but not as a FK
		#! If anything is changed or deleted, the receipt must remain the same
	rcp_id int,
	prd_id int,						# Taken from products table (prd_id)
	product varchar(75),			# Taken from products table (name)
		# This column data type may be changed into a decimal/float depeding on the company
	quantity int default 1,
	unit_price decimal (4,2),	# Taken from products providers (pvp)
	discount int(3) default 0,
		# Calculated value: amount=unit_price*quantity(1-discount)
	amount decimal (4,2),
	iva int(2),						# Taken from products table (iva)
	# Constraints
	constraint ID_RCP_PRD_PK primary key (rcp_id,prd_id),
	constraint ID_RCP_FK foreign key (rcp_id) references company.receipts(rcp_id)
);