/*!
 * @name autocomplete
 * @version 1.9.0
 * @author Grzegorz Tomicki
 * @link https://github.com/tomickigrzegorz/autocomplete
 * @license MIT
 */
var Autocomplete = (function () {
  'use strict'
  const t = (t, s) => {
      for (let i in s) 'addClass' === i ? e(t, 'add', s[i]) : 'removeClass' === i ? e(t, 'remove', s[i]) : t.setAttribute(i, s[i])
    },
    s = (t) => (t.firstElementChild || t).textContent.trim(),
    i = (t, s) => {
      t.scrollTop = t.offsetTop - s.offsetHeight
    },
    h = function (t, s) {
      void 0 === t && (t = !1), t && (e(t, 'remove', 'hidden'), r(t, 'click', s))
    },
    e = (t, s, i) => t.classList[s](i),
    a = (s, i) => {
      t(s, { 'aria-activedescendant': i || '' })
    },
    n = (t, s, i, h) => {
      const e = h.previousSibling,
        a = e ? e.offsetHeight : 0
      if (
        ('0' == t.getAttribute('aria-posinset') &&
          (h.scrollTop =
            t.offsetTop -
            ((t, s) => {
              const i = document.querySelectorAll(`#${t} > li:not(.${s})`)
              let h = 0
              return [].slice.call(i).map((t) => (h += t.offsetHeight)), h
            })(s, i)),
        t.offsetTop - a < h.scrollTop)
      )
        h.scrollTop = t.offsetTop - a
      else {
        const s = t.offsetTop + t.offsetHeight - a
        s > h.scrollTop + h.offsetHeight && (h.scrollTop = s - h.offsetHeight)
      }
    },
    l = (t) => document.createElement(t),
    o = (t) => document.querySelector(t),
    r = (t, s, i) => {
      t.addEventListener(s, i)
    },
    c = (t, s, i) => {
      t.removeEventListener(s, i)
    },
    d = 27,
    u = 13,
    m = 38,
    p = 40,
    $ = 9
  return class {
    constructor(v, b) {
      let {
        delay: f = 500,
        clearButton: x = !0,
        clearButtonOnInitial: C = !1,
        howManyCharacters: y = 1,
        selectFirst: k = !1,
        insertToInput: w = !1,
        showAllValues: g = !1,
        cache: j = !1,
        disableCloseOnSelect: S = !1,
        preventScrollUp: V = !1,
        classGroup: O,
        classPreventClosing: I,
        classPrefix: A,
        ariaLabelClear: R,
        onSearch: B,
        onResults: P = () => {},
        onSubmit: T = () => {},
        onOpened: G = () => {},
        onReset: J = () => {},
        onRender: N = () => {},
        onClose: q = () => {},
        noResults: z = () => {},
        onSelectedItem: E = () => {},
      } = b
      var F
      ;(this.t = () => {
        var s, i, e, a, n
        this.i(),
          (s = this.h),
          (i = this.l),
          (e = this.o),
          (a = this.u),
          (n = this.m),
          t(i, { id: e, tabIndex: '0', role: 'listbox' }),
          t(a, { addClass: `${n}-results-wrapper` }),
          a.insertAdjacentElement('beforeend', i),
          s.parentNode.insertBefore(a, s.nextSibling),
          r(this.h, 'input', this.p),
          this.$ && r(this.h, 'click', this.p),
          this.v({ element: this.h, results: this.l }),
          this.C && h(this.k, this.destroy)
      }),
        (this.j = (t, s) => {
          this.S && ('update' === t ? this.h.setAttribute(this.V, s.value) : 'remove' === t ? this.h.removeAttribute(this.V) : (this.h.value = this.h.getAttribute(this.V)))
        }),
        (this.p = (t) => {
          let { target: s, type: i } = t
          if ('true' === this.h.getAttribute('aria-expanded') && 'click' === i) return
          const h = s.value.replace(this.O, '\\$&')
          this.j('update', s)
          const e = this.$ ? 0 : this.I
          clearTimeout(this.A),
            (this.A = setTimeout(() => {
              this.R(h.trim())
            }, e))
        }),
        (this.B = () => {
          var s
          e(this.u, 'remove', this.P)
          const i = { 'aria-owns': `${this.T}-list`, 'aria-expanded': 'false', 'aria-autocomplete': 'list', role: 'combobox', removeClass: 'auto-expanded' },
            h = this.G ? i : { ...i, 'aria-activedescendant': '' }
          t(this.h, h), this.G || (this.J(o(`.${this.N}`)), (this.q = this.F ? 0 : -1)), ((0 == (null == (s = this.L) ? void 0 : s.length) && !this.M) || this.$) && (this.l.textContent = ''), this.U()
        }),
        (this.R = (t) => {
          ;(this.D = t),
            this.H(!0),
            h(this.k, this.destroy),
            0 == t.length && this.K && e(this.k, 'add', 'hidden'),
            this.W > t.length && !this.$
              ? this.H()
              : this.X({ currentValue: t, element: this.h })
                  .then((s) => {
                    const i = this.h.value.length,
                      h = s.length
                    ;(this.L = Array.isArray(s) ? s : JSON.parse(JSON.stringify(s))),
                      this.H(),
                      this.Y(),
                      0 == h && 0 == i && e(this.k, 'add', 'hidden'),
                      0 == h && i
                        ? (e(this.h, 'remove', 'auto-expanded'), this.B(), this.Z({ element: this.h, currentValue: t, template: this._ }), this.tt())
                        : (h > 0 || ((t) => t && 'object' == typeof t && t.constructor === Object)(s)) && ((this.q = this.F ? 0 : -1), this._(), this.tt())
                  })
                  .catch(() => {
                    this.H(), this.B()
                  })
        }),
        (this.H = (t) => this.h.parentNode.classList[t ? 'add' : 'remove'](this.st)),
        (this.Y = () => e(this.h, 'remove', this.it)),
        (this.tt = () => {
          r(this.h, 'keydown', this.ht),
            r(this.h, 'click', this.et),
            r(document, 'click', this.nt),
            ['mousemove', 'click'].map((t) => {
              r(this.l, t, this.lt)
            })
        }),
        (this._ = (s) => {
          t(this.h, { 'aria-expanded': 'true', addClass: `${this.m}-expanded` }), (this.l.textContent = '')
          const h = 0 === this.L.length ? this.ot({ currentValue: this.D, matches: 0, template: s }) : this.ot({ currentValue: this.D, matches: this.L, classGroup: this.rt })
          this.l.insertAdjacentHTML('afterbegin', h), e(this.u, 'add', this.P)
          const a = this.rt ? `:not(.${this.rt})` : ''
          ;(this.ct = document.querySelectorAll(`#${this.o} > li${a}`)),
            ((s) => {
              for (let i = 0; i < s.length; i++) t(s[i], { role: 'option', tabindex: '-1', 'aria-selected': 'false', 'aria-setsize': s.length, 'aria-posinset': i })
            })(this.ct),
            this.dt({ type: 'results', element: this.h, results: this.l }),
            this.ut(),
            i(this.l, this.u)
        }),
        (this.nt = (t) => {
          let { target: s } = t,
            i = null
          ;((s.closest('ul') && this.$t) || s.closest(`.${this.vt}`)) && (i = !0), s.id === this.T || i || this.B()
        }),
        (this.ut = () => {
          if ((this.J(o(`.${this.N}`)), !this.F)) return
          const { firstElementChild: s } = this.l,
            i = this.rt && this.L.length > 0 && this.F ? s.nextElementSibling : s
          this.bt({ index: this.q, element: this.h, object: this.L[this.q] }), t(i, { id: `${this.ft}-0`, addClass: this.N, 'aria-selected': 'true' }), a(this.h, `${this.ft}-0`)
        }),
        (this.et = () => {
          if (this.l.textContent.length > 0 && !e(this.u, 'contains', this.P)) {
            if ((t(this.h, { 'aria-expanded': 'true', addClass: `${this.m}-expanded` }), e(this.u, 'add', this.P), this.G || (i(this.l, this.u), this.ut()), this.dt({ type: 'showItems', element: this.h, results: this.l }), !this.S)) return
            this.j('update', this.h)
          }
        }),
        (this.lt = (t) => {
          t.preventDefault()
          const { target: s, type: i } = t,
            h = s.closest('li'),
            a = null == h ? void 0 : h.hasAttribute('role'),
            n = this.N,
            l = o(`.${n}`)
          h && a && !s.closest(`.${this.vt}`) && ('click' === i && this.xt(h), 'mousemove' !== i || e(h, 'contains', n) || (this.J(l), this.Ct(h), (this.q = this.yt(h)), this.bt({ index: this.q, element: this.h, object: this.L[this.q] })))
        }),
        (this.xt = (t) => {
          t && 0 !== this.L.length
            ? (this.K && e(this.k, 'remove', 'hidden'), (this.h.value = s(t)), this.kt({ index: this.q, element: this.h, object: this.L[this.q], results: this.l }), this.$t || (this.G || this.J(t), this.B()), this.j('remove'))
            : !this.$t && this.B()
        }),
        (this.yt = (t) => Array.prototype.indexOf.call(this.ct, t)),
        (this.ht = (t) => {
          const { keyCode: i } = t,
            h = e(this.u, 'contains', this.P),
            n = this.L.length + 1
          switch (((this.wt = o(`.${this.N}`)), i)) {
            case m:
            case p:
              if ((t.preventDefault(), (n <= 1 && this.F) || !h)) return
              if ((i === m ? (this.q < 0 && (this.q = n - 1), (this.q -= 1)) : ((this.q += 1), this.q >= n && (this.q = 0)), this.J(this.wt), this.q >= 0 && this.q < n - 1)) {
                const t = this.ct[this.q]
                this.M && h && (this.h.value = s(t)), this.bt({ index: this.q, element: this.h, object: this.L[this.q] }), this.Ct(t)
              } else this.j(), a(this.h), this.bt({ index: null, element: this.h, object: null })
              break
            case u:
              t.preventDefault(), this.xt(this.wt)
              break
            case $:
            case d:
              t.stopPropagation(), this.B()
          }
        }),
        (this.Ct = (s) => {
          const i = `${this.ft}-${this.yt(s)}`
          t(s, { id: i, 'aria-selected': 'true', addClass: this.N }), a(this.h, i), n(s, this.o, this.rt, this.l)
        }),
        (this.J = (s) => {
          s && t(s, { id: '', removeClass: this.N, 'aria-selected': 'false' })
        }),
        (this.i = () => {
          this.K && (t(this.k, { class: `${this.m}-clear hidden`, type: 'button', title: this.gt, 'aria-label': this.gt }), this.h.insertAdjacentElement('afterend', this.k))
        }),
        (this.rerender = (t) => {
          const s = null != t && t.trim() ? t.trim() : this.h.value
          null != t && t.trim() && ((this.h.value = t.trim()), this.j('update', this.h))
          const i = s.replace(this.O, '\\$&')
          this.R(i.trim())
        }),
        (this.destroy = () => {
          this.K && e(this.k, 'add', 'hidden'), (this.h.value = ''), this.h.focus(), (this.l.textContent = ''), this.B(), this.Y(), this.jt(this.h), c(this.h, 'keydown', this.ht), c(this.h, 'click', this.et), c(document, 'click', this.nt)
        }),
        (this.T = v),
        (this.h = document.getElementById(v)),
        (this.X =
          ((F = B),
          Boolean(F && 'function' == typeof F.then)
            ? B
            : (t) => {
                let { currentValue: s, element: i } = t
                return Promise.resolve(B({ currentValue: s, element: i }))
              })),
        (this.ot = P),
        (this.v = N),
        (this.kt = T),
        (this.bt = E),
        (this.dt = G),
        (this.jt = J),
        (this.Z = z),
        (this.U = q),
        (this.I = f),
        (this.W = y),
        (this.K = x),
        (this.C = C),
        (this.F = k),
        (this.M = w),
        (this.$ = g),
        (this.rt = O),
        (this.vt = I),
        (this.gt = R || 'clear the search query'),
        (this.m = A ? `${A}-auto` : 'auto'),
        (this.$t = S),
        (this.G = V),
        (this.S = j),
        (this.o = `${this.m}-${this.T}-results`),
        (this.V = `data-cache-auto-${this.T}`),
        (this.st = `${this.m}-is-loading`),
        (this.P = `${this.m}-is-active`),
        (this.N = `${this.m}-selected`),
        (this.ft = `${this.m}-selected-option`),
        (this.it = `${this.m}-error`),
        (this.O = /[|\\{}()[\]^$+*?.]/g),
        (this.A = null),
        (this.u = l('div')),
        (this.l = l('ul')),
        (this.k = l('button')),
        this.t()
    }
  }
})()
//# sourceMappingURL=autocomplete.min.js.map
