import urllib2

with open("cookies.txt") as file:
	lines = file.readlines()
	cookie = {}
	for line in lines:
		line = line.strip()
		if line.startswith("Cookie:"):
			line = line[8:]
			cookie = line
			break

opener = urllib2.build_opener()
opener.addheaders.append(('Cookie', cookie))
file = opener.open("http://localhost:8888/private.php")
html = file.read()
print(html)
print("http://localhost:8888/private.php")
