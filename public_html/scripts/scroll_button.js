// ===== Scroll to Top ====
window.onscroll = function() {
    if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
        document.getElementById("myBtn").style.display = "flex";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
};

document.getElementById("myBtn").addEventListener("click", () => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});