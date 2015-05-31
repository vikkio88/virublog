#!/usr/bin/env ruby
require 'net/http'
require 'uri'
 def Boolean(string)
   return true if string == true || string =~ /^true$/i
   return false
end

#The configuration script for virublog client
#configclient.rb
puts "***********************************"
puts "*        virublog-Client          *"
puts "*               1.0               *"
puts "* ________________________________*"
puts "* Configuration script            *"
puts "***********************************"
puts "Before run this you must be sure to have correctly" 
puts "installed your serverside CMS virublog..."
puts "If you haven't configured and upped to your webdir"
puts "the php CMS you must exit now from this script..."
puts "_________________"
puts "Have you already upped all files in tour website? (y/n)"
puts "_________________"
ans=gets.chomp.upcase
if (ans.to_s!="Y")
	puts "....Ok goodbye!"
	puts "....... =("
	puts "_______________"
	exit
else
	cntrl=false
	site=""
	while (cntrl==false)
		puts "Give me the site address where your CMS is upped:"
		puts "correct format: http://yoursite.som/dir <= no put '/' after dir!!!"
		site=gets.chomp
		temp=site.scan(/http:\/\/.+\..+\/?.?/)
		if (!(temp.empty?))
			cntrl=true
		else
			puts "..."
			puts "no correct format of a website: (http://yoursite.som/dir <= no put / after dir!!!)"
			puts "retry..."
			puts
		end
	end
	puts "_________________"
	puts "Site format correct..."
	puts ""
	puts "Insert admin password:"
	pass=gets.chomp
	puts "_________________"
	puts "I'm checking if password is correct with remote CMS..."
	urlconfig = URI.parse(site+"/config.php")
	res = Net::HTTP.post_form(urlconfig,{'pass'=>"#{pass}"})
	authpass=(res.body)
	if (Boolean(authpass))
		puts "Your password is correct!"
		puts "Let me write saved files..."
		puts "Do you want save your password?"
		save=false
		ans=gets.chomp.upcase
		if (ans=="Y")
			save=true
		end
		puts "...OK"
		puts ".....Wait"
		f1=File.open("saved.rb",'w')
		if (save)
			f1.puts("$saved=\"#{pass}\"")
		else
			f1.puts("$saved=nil")
		end
		f1.puts("$noaskagain=false")
		f1.puts("$sito=\"#{site}\"")
		f1.close
		File.delete("configclient.rb")
	else
		puts "YourPassword in site is incorrect...plese retry =(!"
		exit
	end
	
	
end
