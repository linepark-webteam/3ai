/**
 * サービス詳細セクションに応じて
 * ナビリンクをハイライトするスクリプト
 */
(() => {
  const navLinks = document.querySelectorAll(".services__nav-link");
  const sections = [...document.querySelectorAll(".services__detail")];

  /* Smooth-scroll */
  navLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      e.preventDefault();
      const target = document.querySelector(link.getAttribute("href"));
      target?.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });

  /* Intersection Observer */
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          navLinks.forEach((l) =>
            l.classList.toggle(
              "is-active",
              l.getAttribute("href").slice(1) === entry.target.id
            )
          );
        }
      });
    },
    {
      rootMargin: "-40% 0px -40% 0px",
    }
  );

  sections.forEach((section) => observer.observe(section));
})();

/*---------------------------------
  スクロールに合わせて各セクションスライドフェードイン
---------------------------------*/
document.addEventListener("DOMContentLoaded", () => {
  const targets = document.querySelectorAll(".services__detail");

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          // 一度表示したら監視を停止（再度隠したくない場合）
          io.unobserve(entry.target);
        }
      });
    },
    {
      rootMargin: "0px 0px -10% 0px", // 少し手前でトリガー
      threshold: 0.2,
    }
  );

  targets.forEach((el) => io.observe(el));
});
