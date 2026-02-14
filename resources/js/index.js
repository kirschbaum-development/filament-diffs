import { FileDiff, parseDiffFromFile } from '@pierre/diffs'

document.addEventListener('alpine:init', () => {
    window.Alpine.data('diffEntry', ({ old: oldContent, new: newContent, fileName, language, options }) => ({
        instance: null,

        init() {
            const oldFile = { name: fileName ?? '', contents: oldContent ?? '', lang: language }
            const newFile = { name: fileName ?? '', contents: newContent ?? '', lang: language }

            this.instance = new FileDiff(options ?? {})

            this.instance.render({
                oldFile,
                newFile,
                fileDiff: parseDiffFromFile(oldFile, newFile),
                fileContainer: this.$refs.container,
            })
        },

        destroy() {
            this.instance?.cleanUp()
            this.instance = null
        },
    }))
})
