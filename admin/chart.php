<!DOCTYPE HTML>
<html>
<head>
</head>
	<body style="background:white;">
		<script>
			console.log(getInitials("Kennedy wekesir"));
			function getInitials(name){
				var nameSplit = name.split(" ");
				var nameInitials = nameSplit[0].slice(0,1).toUpperCase();
				 if (nameSplit.length > 1) {
						nameInitials += nameSplit[nameSplit.length - 1].slice(0, 1).toUpperCase();
					}
				return nameInitials;
			}


			console.log(extraString("Kennedy Wekesir","2","5"));
			function extraString(sentence,start,end){
				//slice() substr() and the substring() methods are similar in how they function
				return sentence.slice(start, end);
			}

			console.log(trimEdges("    wekesir"));
			function trimEdges(sentence){
				return sentence.trim();
			}

			console.log(changeCase("Kennedy Wekesir","lower"));
			function changeCase(sentence,c){
				if(c == "upper"){
					return sentence.toUpperCase();
				}else if(c == "lower"){
					return sentence.toLowerCase();
				}
			}

			console.log(replaceString("Kennedy Wekesir","Kennedy","Wekeesi 1"));
			function replaceString(word,search,replaceWith){
				return word.replace(search,replaceWith);
			}
		</script>
	</body>
</body>
</html>