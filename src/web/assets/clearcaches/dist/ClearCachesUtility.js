!function(){var t;t=jQuery,Craft.ClearCachesUtility=Garnish.Base.extend({init:function(a){for(var e=this,s=t("form.utility"),r=function(t){var a=s.eq(t),r=a.find("input[type=checkbox]"),n=a.find(".btn"),i=function(){r.filter(":checked").length?n.removeClass("disabled"):n.addClass("disabled")};r.on("change",i),i(),e.addListener(a,"submit",(function(t){t.preventDefault(),n.hasClass("disabled")||e.onSubmit(t)}))},n=0;n<s.length;n++)r(n)},onSubmit:function(a){var e,s,r=t(a.currentTarget),n=r.find("button.submit"),i=r.find(".utility-status");n.hasClass("disabled")||(r.data("progressBar")?((e=r.data("progressBar")).resetProgressBar(),s=r.data("allDone")):(e=new Craft.ProgressBar(i),r.data("progressBar",e)),e.$progressBar.removeClass("hidden"),e.$progressBar.velocity("stop").velocity({opacity:1},{complete:function(){var a=Garnish.getPostData(r),o=Craft.expandPostArray(a);Craft.sendActionRequest("POST",o.action,{data:o}).then((function(a){e.setProgressPercentage(100),setTimeout((function(){s||((s=t('<div class="alldone" data-icon="done" />').appendTo(i)).css("opacity",0),r.data("allDone",s)),e.$progressBar.velocity({opacity:0},{duration:"fast",complete:function(){s.velocity({opacity:1},{duration:"fast"}),n.removeClass("disabled"),n.trigger("focus")}})}),300)})).catch((function(t){var a=t.response;alert(a.message)})).finally((function(){return t.noop}))}}),s&&s.css("opacity",0),n.addClass("disabled"),n.trigger("blur"))}})}();
//# sourceMappingURL=ClearCachesUtility.js.map