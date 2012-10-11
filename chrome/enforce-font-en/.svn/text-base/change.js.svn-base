/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//document.body.innerHTML+="<style>*{font-family:'微软雅黑' !important;}</style>";
// Copyright (c) 2010 The Chromium Authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.

chrome.extension.onRequest.addListener(
    function(request, sender, sendResponse) {
        if(request.cmd=="style"&&localStorage["enforce_font"]=="true"){
    
            sendResponse({
                name:localStorage["font_name"],
                b_list:localStorage["b_list"],
                size:localStorage["enforce_size"]
            })
       
        }
    });

