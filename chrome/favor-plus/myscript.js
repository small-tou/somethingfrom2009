chrome.extension.sendRequest({
    cmd:"show_page_action",
    title:document.title,
    url:window.location.href
});
