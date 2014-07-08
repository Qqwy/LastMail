(function(){function e(e){for(var t=[/for\s*?\((.*?)\)/,/\"(.*?)(\"|$)/,/\'(.*?)(\'|$)/,/\/\*(.*?)(\*\/|$)/,/\/\/.*/],n=[],i=0;t.length>i;i++)for(var a=0;e.length>a;){var r=e.substr(a).match(t[i]);if(null==r)break;n.push({start:a+r.index,end:a+r.index+r[0].length}),a+=r.index+Math.max(1,r[0].length)}return n.sort(function(e,t){return e.start-t.start}),n}function t(e,t){return CodeMirror.innerMode(e.getMode(),e.getTokenAt(t).state).mode}function n(e,t,n,i){var a=e.getMode(),r=e.getLine(t);if(null==i&&(i=r.length),!a.innerMode)return[{from:n,to:i,mode:a}];var o=e.getTokenAt({line:t,ch:n}).state,s=CodeMirror.innerMode(a,o).mode,l=[],c=new CodeMirror.StringStream(r);for(c.pos=c.start=n;;){a.token(c,o);var u=CodeMirror.innerMode(a,o).mode;if(u!=s){var d=c.start;"xml"==s.name&&">"==r.charAt(c.pos-1)&&(d=c.pos),l.push({from:n,to:d,mode:s}),n=d,s=u}if(c.pos>=i)break;c.start=c.pos}return i>n&&l.push({from:n,to:i,mode:s}),l}CodeMirror.extendMode("css",{commentStart:"/*",commentEnd:"*/",wordWrapChars:[";","\\{","\\}"],autoFormatLineBreaks:function(e){return e.replace(RegExp("(;|\\{|\\})([^\r\n])","g"),"$1\n$2")}}),CodeMirror.extendMode("javascript",{commentStart:"/*",commentEnd:"*/",wordWrapChars:[";","\\{","\\}"],autoFormatLineBreaks:function(t){var n=0,i=this.jsonMode?function(e){return e.replace(/([,{])/g,"$1\n").replace(/}/g,"\n}")}:function(e){return e.replace(/(;|\{|\})([^\r\n;])/g,"$1\n$2")},a=e(t),r="";if(null!=a){for(var o=0;a.length>o;o++)a[o].start>n&&(r+=i(t.substring(n,a[o].start)),n=a[o].start),n>=a[o].start&&a[o].end>=n&&(r+=t.substring(n,a[o].end),n=a[o].end);t.length>n&&(r+=i(t.substr(n)))}else r=i(t);return r.replace(/^\n*|\n*$/,"")}}),CodeMirror.extendMode("xml",{commentStart:"<!--",commentEnd:"-->",wordWrapChars:[">"],autoFormatLineBreaks:function(e){for(var t=e.split("\n"),n=RegExp("(^\\s*?<|^[^<]*?)(.+)(>\\s*?$|[^>]*?$)"),i=RegExp("<","g"),a=RegExp("(>)([^\r\n])","g"),r=0;t.length>r;r++){var o=t[r].match(n);null!=o&&o.length>3&&(t[r]=o[1]+o[2].replace(i,"\n$&").replace(a,"$1\n$2")+o[3])}return t.join("\n")}}),CodeMirror.defineExtension("commentRange",function(e,n,i){var a=t(this,n),r=this;this.operation(function(){if(e)r.replaceRange(a.commentEnd,i),r.replaceRange(a.commentStart,n),n.line==i.line&&n.ch==i.ch&&r.setCursor(n.line,n.ch+a.commentStart.length);else{var t=r.getRange(n,i),o=t.indexOf(a.commentStart),s=t.lastIndexOf(a.commentEnd);o>-1&&s>-1&&s>o&&(t=t.substr(0,o)+t.substring(o+a.commentStart.length,s)+t.substr(s+a.commentEnd.length)),r.replaceRange(t,n,i)}})}),CodeMirror.defineExtension("autoIndentRange",function(e,t){var n=this;this.operation(function(){for(var i=e.line;t.line>=i;i++)n.indentLine(i,"smart")})}),CodeMirror.defineExtension("autoFormatRange",function(e,t){var i=this;i.operation(function(){for(var a=e.line,r=t.line;r>=a;++a){for(var o={line:a,ch:a==e.line?e.ch:0},s={line:a,ch:a==r?t.ch:null},l=n(i,a,o.ch,s.ch),c="",u=i.getRange(o,s),d=0;l.length>d;++d){var p=l.length>1?u.slice(l[d].from,l[d].to):u;c&&(c+="\n"),c+=l[d].mode.autoFormatLineBreaks?l[d].mode.autoFormatLineBreaks(p):u}if(c!=u){for(var m=0,h=c.indexOf("\n");-1!=h;h=c.indexOf("\n",h+1),++m);i.replaceRange(c,o,s),a+=m,r+=m}}for(var a=e.line+1;r>=a;++a)i.indentLine(a,"smart");i.setSelection(e,i.getCursor(!1))})})})();