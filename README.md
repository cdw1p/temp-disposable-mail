# temp-disposable-mail
Temporary &amp; Disposable Mail Script

### Installation
1. Upload files to your host
2. Go to cpanel -> Default Address
3. Select domain and choose "Pipe to a Program"
4. Add this line to it: public_html/pipe.php
5. Done!

### Add time for automatically delete email after X day/hour/minutes
1. Open inc/list.php file and find:
	$time = time()-604800; [Line 28]

2. Change (604800) to your desired time in seconds
example: 7[day]*24[hour]*60[minutes]*60[seconds]=604800 seconds
