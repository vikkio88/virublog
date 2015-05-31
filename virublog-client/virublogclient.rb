#!/usr/bin/env ruby
require 'net/http'
require 'uri'
require "./include/addfunc.rb"
require 'readline'
if File.exist?("saved.rb")
	require "saved.rb"
	config=true
else
	config=false
end


if (!(config))
			puts "***********************************"
			puts "*        virublog-Client          *"
			puts "*               1.0               *"
			puts "* ________________________________*"
			puts "* NoTConfigured client            *"
			puts "***********************************"
			puts
			puts "Your client is not configured correctly!"
			puts "Run the configure script (configclient.rb)"
			puts "in this dir before use virublog client."
	exit
else

urlconfig = URI.parse($sito+"/config.php")
urlfiles = URI.parse($sito+"/fileman/fileman.php")
urlpost=  URI.parse($sito+"/post.php")
urldel=URI.parse($sito+"/fileman/del.php")
urlcssnavi=URI.parse($sito+"/fileman/cssnavi.php")
urlcssswap=URI.parse($sito+"/grafica/cssswap.php")
end
if __FILE__ == $0
		passwd=$saved.to_s
		authpass=nil
		if $saved==nil 
			puts "Inserisci password admin:"
			passwd=gets.chomp
			
			res = Net::HTTP.post_form(urlconfig,{'pass'=>"#{passwd}"})
			authpass=(res.body)
			if $noaskagain==false
				puts "Vuoi Salvare la password?(y/n/d(=dontaskagain):"
				answer=gets.chomp
				answer.upcase!
				case answer
				when "Y" then
					save_passwd(passwd)
				when "D" then
					dont_ask()
				end
			end
		else
			res = Net::HTTP.post_form(urlconfig,{'pass'=>"#{passwd}"})
			authpass=(res.body)
		end
		#Stampo se la password è giusta o meno di ritorno dal sito
		#puts authpass.to_s
		
		if Boolean(authpass)==true or $saved!=nil
			puts "***********************************"
			puts "*        virublog-Client          *"
			puts "*               1.0               *"
			puts "* ________________________________*"
			puts "* MainMenu                        *"
			puts "***********************************"
			puts "_ 1) Post"
			puts "_ 2) DeletePost"
			puts "_ 3) ChangeTemplate"
			risp=gets.chomp
			risp=risp.to_i
			case risp
				when 1 then
					posta(urlpost,passwd)
				when 2 then
					id=getfile(urlfiles,passwd)
					deletefile(id,urldel,passwd)
				when 3 then
					editcss(urlcssnavi,urlcssswap,passwd)
				end
			#puts passwd
			
		else
			puts "WrongPasswd\nRetry!"
		end

end
