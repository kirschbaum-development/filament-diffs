import { File, FileDiff } from '@pierre/diffs'

document.addEventListener('alpine:init', () => {
    window.Alpine.data('filamentFileEntry', ({ content, fileName, language, options }) => ({
        instance: null,

        init() {
            this.render()
        },

        render() {
            this.cleanup()

            const file = {
                name: fileName || 'file',
                contents: content || '',
                ...(language ? { lang: language } : {}),
            }

            this.instance = new File(options || {})

            this.instance.render({
                file,
                containerWrapper: this.$refs.mount,
            })
        },

        cleanup() {
            if (this.instance) {
                this.instance.cleanUp()
                this.instance = null
            }
        },

        destroy() {
            this.cleanup()
        },
    }))

    window.Alpine.data('filamentFileDiffEntry', ({ old: oldContents, new: newContents, fileName, language, options }) => ({
        instance: null,

        init() {
            this.render()
        },

        render() {
            this.cleanup()

            const oldFile = {
                name: fileName || 'file',
                contents: oldContents || '',
                ...(language ? { lang: language } : {}),
            }

            const newFile = {
                name: fileName || 'file',
                contents: newContents || '',
                ...(language ? { lang: language } : {}),
            }

            this.instance = new FileDiff(options || {})

            this.instance.render({
                oldFile,
                newFile,
                containerWrapper: this.$refs.mount,
            })
        },

        cleanup() {
            if (this.instance) {
                this.instance.cleanUp()
                this.instance = null
            }
        },

        destroy() {
            this.cleanup()
        },
    }))
})
