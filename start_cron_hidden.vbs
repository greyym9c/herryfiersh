Set WshShell = CreateObject("WScript.Shell")
WshShell.Run chr(34) & "c:\xampp\htdocs\herryfiersh\run_cron.bat" & Chr(34), 0
Set WshShell = Nothing
