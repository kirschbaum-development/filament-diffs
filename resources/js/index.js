import { FileDiff } from '@pierre/diffs'

document.addEventListener('alpine:init', () => {
    window.Alpine.data('filamentDiffs', ({ old: oldContents, new: newContents, fileName, language, options }) => ({
        instance: null,

        init() {
            this.render()
        },

        render() {
            this.cleanup()

            const oldFile = {
                fileName: fileName || 'file',
                contents: oldContents || '',
            }

            const newFile = {
                fileName: fileName || 'file',
                contents: newContents || '',
            }

            this.instance = new FileDiff({
                oldFile,
                newFile,
                ...(options || {}),
            })

            this.instance.mount(this.$refs.mount)
        },

        cleanup() {
            if (this.instance) {
                this.instance.destroy()
                this.instance = null
            }
        },

        destroy() {
            this.cleanup()
        },
    }))
})
