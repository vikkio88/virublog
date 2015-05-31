def posteditor
##viROSE post editor :D
	puts "viROSE post editor[beta]"
	puts "termina l'inserimento con un punto su una riga vuota \'.\'"
	list = ['[url]', '[url','[/url]','[img]','[/img]','[b]','[/b]','[i]','[/i]','[youtube]','[/youtube]','[code]','[/code]'].sort
	comp = proc { |s| list.grep( /^#{Regexp.escape(s)}/ ) }
	testo=""
	Readline.completion_append_character = ""
	Readline.completion_proc = comp
	while ((line = Readline.readline('', true))!=".")
		testo+=(line+="\n")
	end
	
	return testo
end

def spurge(messaggio)
	tagnumb=messaggio.scan(/\[code\](.*?)\[\/code\]/).size
	if (tagnumb)
		capt=messaggio.scan(/\[code\](.*?)\[\/code\]/)
		capt.each do |i|
			sprunged=post_on_sprunge(i)
			messaggio = messaggio.sub(/\[code\](.*?)\[\/code\]/, "<iframe src=\"#{sprunged}\" width=\"95%\">click <a href=\"#{sprunged}\" title=\"code\">here</a> to see the code</iframe>") if (sprunged!=false)
		end

		return messaggio
		
	else
		return messaggio
	end
end

def post_on_sprunge(sorgente)
	def sprunga(testofile)
		url=URI.parse('http://sprunge.us/index.php');
		puts "I'm sprunging a source..."
		res = Net::HTTP.post_form(url,{'sprunge'=>"#{(testofile)}"})
		puts "sprunged!"
		return (res.body.to_s)
	end
sorgente=sorgente.to_s
if (sorgente!="")
	if (File.exist?(sorgente))
		f1=File.open(sorgente,'r')
		estenzione=sorgente.gsub(/.+\./,'')
		testofile=f1.readlines
		url=sprunga(testofile)
		url.chomp!
		url=url+"?"+estenzione
		return url
	else
		return false
	end
	
else
	return false
end
end

def special_chars(stringa)
stringa=stringa.gsub(/à/,"&agrave;")
stringa=stringa.gsub(/è/,"&egrave;")
stringa=stringa.gsub(/ì/,"&igrave;")
stringa=stringa.gsub(/ò/,"&ograve;")
stringa=stringa.gsub(/ù/,"&ugrave;")
stringa=stringa.gsub(/é/,"&eacute;")
stringa=stringa.gsub(/ & /," &amp; ")
#stringa=stringa.gsub(/>"/,">&quot;")
#stringa=stringa.gsub(/"</,"&quot;<")
stringa=stringa.gsub(/μ/,"&mu;")
stringa=stringa.gsub(/\n/,"<br />")
return stringa
end

def getfile(urlfiles,passwd)
	res = Net::HTTP.post_form(urlfiles,{'passwd'=>"#{passwd}"})
	puts res.body
	puts "__________________\nInsert id of post you want delete:"
	id=gets.chomp
	return id
end

def deletefile(id,urldel,passwd)
	
	res = Net::HTTP.post_form(urldel,{'id'=>"#{id}",'passwd'=>"#{passwd}"})
	puts res.body
end

def posta(urlpost,passwd)
	puts "Inserisci un titolo per il post:\n"
	title=gets.chomp
	title=special_chars(title)
	puts "Inserisci il corpo del messaggio(bbcode permesso)"
	body=posteditor
	body=special_chars(body)
	#Da sistemare
	body=spurge(body)
	res = Net::HTTP.post_form(urlpost,{'titolo'=>"#{title}",'corpo'=>"#{body}",'passwd'=>"#{passwd}"})
	puts "---Posting---"
	#puts body
	puts res.body
end

def save_passwd(passwd)
	f1=File.open("saved.rb",'r')
	one=f1.gets;
	two=f1.gets;
	three=f1.gets;
	one="$saved=\"#{passwd}\""
	f1.close
	f1=File.open("saved.rb",'w')
	f1.puts one
	f1.puts two
	f1.puts three
	f1.close
end

def dont_ask()
	f1=File.open("saved.rb",'r')
	one=f1.gets;
	two=f1.gets;
	three=f1.gets;
	two="$noaskagain=true"
	f1.close
	f1=File.open("saved.rb",'w')
	f1.puts one
	f1.puts two
	f1.puts three
	f1.close
end

 def Boolean(string)
   return true if string == true || string =~ /^true$/i
   return false #if string == false || string.nil? || string =~ /^false$/i
   #raise ArgumentError.new("invalid value for Boolean: \"#{string}\"")
end


def editcss(urlnav,urlsw,passwd)
			puts "***********************************"
			puts "* EditTemplate                    *"
			puts "***********************************"
			puts "Switch CSS"
			puts "_________________________"
			Net::HTTP.get_print urlnav
			puts "Choose cssid to swap with:"
			cssid=gets.chomp
			res = Net::HTTP.post_form(urlsw,{'id'=>"#{cssid}",'passwd'=>"#{passwd}"})
			puts res.body
end

