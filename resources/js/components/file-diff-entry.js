import { FileDiff } from '@pierre/diffs'

export default function fileDiffEntry({ old: oldContents, new: newContents, fileName, language, options }) {
    return {
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
    }
}
