'
' cscript zip.vbs <target.zip> <source1> <source2> ... <sourceN>
' 
' Sources may bei files and directories
'
Set objArgs = WScript.Arguments
ZipFile = objArgs(0)

' Create empty ZIP file and open for adding
CreateObject("Scripting.FileSystemObject").CreateTextFile(ZipFile, True).Write "PK" & Chr(5) & Chr(6) & String(18, vbNullChar)
Set zip = CreateObject("Shell.Application").NameSpace(ZipFile)

' Add all files/directories to the .zip file
For i = 1 To objArgs.count-1
  zip.CopyHere(objArgs(i))
  WScript.Sleep 10000 'REQUIRED!! (Depending on file/dir size)
Next
