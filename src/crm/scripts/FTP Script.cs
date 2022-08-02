
// 
// UPLOAD
//

string a_error_message 
string server, user, password
integer port 

server = profilestring("default.ini", "ftp", "server", "server")
user = profilestring("default.ini", "ftp", "user", "user")
password = profilestring("default.ini", "ftp", "password", "password")
port = integer(profilestring("default.ini", "ftp", "port", "21")) 


uo_ftp ftp 
ftp = create uo_ftp 

if not ftp.init(server, user, password, port) then 
	messagebox(title, "Error Initializing FTP~r"+ "server: " + server + "~ruser: " + user + "~rpassword: ***" + "~rport: " + string(port)) 
	goto q
end if 

if not ftp.open() then
	messagebox(title, "Error Openning FTP~r"+ "server: " + server + "~ruser: " + user + "~rpassword: ***" + "~rport: " + string(port)) 
	goto q
end if 


string pathname, filename, destdirectory, encoded 

if getFileOpenName(title, pathname, filename) = 0 then
	return 
end if 

destdirectory = string(today(), "yyyymm") 
encoded = destdirectory + "\cm."  + string(dw_header.getitemnumber(1, "cm_up_id")) + string(today(), "yyyymmddhhmmss") + ".crm"
dw_header.setitem(1, "original_filename", filename)
dw_header.setitem(1, "encoded_filename", encoded)



ftp.mdir(destdirectory) 

if not ftp.sdir(destdirectory) then
	messagebox(title, "Error Setting Directory - " + destdirectory) 
	goto q
end if 

encoded = right(encoded, posr(encoded, "\", 1) - 1)
	
if not ftp.put(pathname, encoded) then
	messagebox(title, "Error uploading " + encoded + "~r~rPlease reupload") 
	goto q 
end if 

ftp.close()
ftp.quit()
destroy ftp